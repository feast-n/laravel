<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BelajarController extends Controller
{
    public function index()
    {
        $title = "Belajar matematika";
        return view('belajar', compact('title'));
    }

    public function penjumlahan()
    {
        $jumlah = 0;
        $title = "Data Penjumlahan";
        return view('tambah', compact('jumlah', 'title'));
    }

    public function storeTambah(Request $request)
    {
        $angka1 = $request->input('angka1');
        $angka2 = $request->input('angka2');

        $jumlah = $angka1 + $angka2;
        $title = "Data Penjumlahan";

        return view('tambah', compact('jumlah', 'title'));
    }

    public function kurang()
    {
        $title = "Data Pengurangan";
        $jumlah = 0;
        return view('kurang', compact('title', 'jumlah'));
    }

    public function storeKurang(Request $request)
    {
        $angka1 = $request->input('angka1');
        $angka2 = $request->input('angka2');

        $jumlah = ($angka1 - $angka2);
        // $jumlah = max(0, $angka1 - $angka2);
        $title = "Data Pengurangan";

        return view('kurang', compact('jumlah', 'title'));
    }

    public function kali()
    {
        $title = "Data Perkalian";
        $jumlah = 0;
        return view('kali', compact('title', 'jumlah'));
    }
    public function storeKali(Request $request)
    {
        $angka1 = $request->input('angka1');
        $angka2 = $request->input('angka2');

        $jumlah = ($angka1 * $angka2);
        $title = "Data Perkalian";
        return view('kali', compact('jumlah', 'title'));
    }
        public function bagi()
    {
        $title = "Data Pembagian";
        $jumlah = 0;
        return view('bagi', compact('title', 'jumlah'));
    }
    public function storeBagi(Request $request)
    {
        $angka1 = $request->input('angka1');
        $angka2 = $request->input('angka2');

        if ($angka2 == 0 || $angka2 == null)
        {
            $jumlah = 0;
        } else {
            $jumlah = $angka1 / $angka2;
        }
        // $jumlah = max(0, $angka1 / $angka2);
        $title = "Data Pembagian";
        return view('bagi', compact('jumlah', 'title'));
    }
}
