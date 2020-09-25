<?php
include_once "Product.php";
$method = @$_GET['method'];
$action = @$_GET['action'];
$error = @$_GET['error'];
$dataId = @$_GET['dataid'];
$product = new Product('localhost', 'root', '', 'arkademy');
$products = $product->index();

if (isset($action) && $action === 'update') {
    $data = $product->show($dataId);
}
if (isset($action) && $action === 'delete') {
    $product->destroy($dataId);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPLE CRUD</title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <?php if (isset($action) && $action === 'add' || $action === 'update') { ?>
                    <div class="pt-4">
                        <form method="POST">
                            <div class="form-group">
                                <label for="nama">Nama Produk</label>
                                <input id="nama" class="form-control" required type="text" value="<?= isset($data) ? $data['nama_produk'] : null ?>" name="nama_produk">
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="jumlah">Harga</label>
                                        <input id="jumlah" class="form-control" required type="text" value="<?= isset($data) ? $data['harga'] : null ?>" name="harga">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="Harga">Jumlah</label>
                                        <input id="Harga" class="form-control" required type="text" value="<?= isset($data) ? $data['jumlah'] : null ?>" name="jumlah">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea id="keterangan" class="form-control" required name="keterangan" rows="3"><?= isset($data) ? $data['keterangan'] : null ?></textarea>
                            </div>
                            <a href="." class="btn btn-primary">Tutup</a>
                            <input type="submit" class="btn btn-success" name="simpan" value="Simpan">
                        </form>
                        <?php if (isset($error) && $error) { ?>
                            <div class="mt-4">
                                <div class="alert alert-danger">
                                    <span>Aksi Gagal</span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php }
                if (isset($_POST['simpan'])) {
                    if (method_exists($product, $method)) {
                        if ($method === 'update') {
                            $_POST['id'] = $dataId;
                        }
                        $product->$method($_POST);
                    } else {
                        echo "Gagal";
                    }
                }
                ?>
                <div class="table-responsive">
                    <div class="d-flex justify-content-between my-4">
                        <h4>Daftar Produk</h4>
                        <a href=".?action=add&method=store" class="btn btn-primary text-white">Tambah Produk</a>
                    </div>
                    <table class="table table-stripped data-table">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Keterangan</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product) { ?>
                                <tr>
                                    <td><?= $product['nama_produk'] ?></td>
                                    <td><?= $product['keterangan'] ?></td>
                                    <td><?= "Rp. " . number_format($product['harga'], 0, ',', '.') ?></td>
                                    <td><?= $product['jumlah'] ?></td>
                                    <td>
                                        <a href=".?action=update&method=update&dataid=<?= $product['id'] ?>" class="btn btn-warning text-white">Edit</a>
                                        <a href=".?action=delete&method=destroy&dataid=<?= $product['id'] ?>" class="btn btn-danger text-white" onclick="confirm('Hapus ?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>