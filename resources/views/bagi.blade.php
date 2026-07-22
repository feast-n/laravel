@extends('belajar')

@section('content')
    <form action="{{ route('store-bagi') }}" method="post" class="calc-form">
        @csrf
        <div class="form-group">
            <label for="angka1" class="form-label">Angka 1</label>
            <input type="number" placeholder="Masukkan angka 1" name="angka1" class="form-input">
        </div>

        <div class="form-group">
            <label for="angka2" class="form-label">Angka 2</label>
            <input type="number" placeholder="Masukkan angka 2" name="angka2" class="form-input">
        </div>

        <div class="action-group">
            <button type="submit" class="btn-submit">simpan</button>
            <a href="/belajar-laravel" class="btn-back">kembali</a>
        </div>
    </form>

    <h3 class="result-title">Hasil Pembagian: {{ $jumlah ?? 0 }}</h3>
@endsection
