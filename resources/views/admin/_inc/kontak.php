<?php
session_start();
include '../koneksi/koneksi.php';

// Ambil data kontak menggunakan Prepared Statement
$stmt = mysqli_prepare($koneksi, "SELECT id, name, email, phone, message FROM contacts ORDER BY id DESC");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kontak Kami - Web Compro</title>

    <?php include '_inc/css.php'; ?>
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include '_inc/sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '_inc/nav.php'; ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Pesan Kontak</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pesan Masuk</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Telepon</th>
                                                    <th>Pesan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($rows)): ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">Belum ada pesan kontak masuk.</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($rows as $index => $row): ?>
                                                        <tr>
                                                            <td><?= $index + 1; ?></td>
                                                            <td><?= htmlspecialchars($row['name'] ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row['email'] ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row['phone'] ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row['message'] ?? ''); ?></td>
                                                            <td class="text-nowrap">
                                                                <a class="btn btn-sm btn-primary" href="view_contact.php?id=<?= (int)$row['id']; ?>">Detail</a>
                                                                <a class="btn btn-sm btn-danger" href="delete_contact.php?id=<?= (int)$row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">Hapus</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php include '_inc/footer.php'; ?>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda siap mengakhiri sesi ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php include '_inc/js.php'; ?>

</body>

</html>