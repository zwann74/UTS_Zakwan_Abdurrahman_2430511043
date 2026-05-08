<?php
include 'koneksi.php';

$id = "";
$nim = "";
$nama = "";
$jurusan = "";
$foto = "";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = mysqli_query($conn,
        "SELECT * FROM mahasiswa WHERE id='$id'");

    $row = mysqli_fetch_assoc($query);

    $nim = $row['nim'];
    $nama = $row['nama_lengkap'];
    $jurusan = $row['jurusan'];
    $foto = $row['foto'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>
        <?= $id ? "Edit Data" : "Tambah Data"; ?>
    </h1>

    <form action="simpan.php"
          method="POST"
          enctype="multipart/form-data"
          onsubmit="return validasiForm()">

        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="foto_lama" value="<?= $foto; ?>">

        <label>NIM</label>
        <input type="text" name="nim" id="nim"
               value="<?= $nim; ?>">

        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap"
               id="nama_lengkap"
               value="<?= $nama; ?>">

        <label>Jurusan</label>
        <input type="text" name="jurusan"
               id="jurusan"
               value="<?= $jurusan; ?>">

        <label>Foto</label>
        <input type="file" name="foto" id="foto">

        <?php if ($foto != "") { ?>
            <img src="uploads/<?= $foto; ?>"
                 width="120">
        <?php } ?>

        <button type="submit" class="btn">
            Simpan
        </button>

        <a href="index.php" class="kembali">
            Kembali
        </a>

    </form>

</div>

<script>

function validasiForm() {

    let nim = document.getElementById("nim").value;
    let nama = document.getElementById("nama_lengkap").value;
    let jurusan = document.getElementById("jurusan").value;
    let foto = document.getElementById("foto");

    if (nim == "" || nama == "" || jurusan == "") {
        alert("Semua field wajib diisi!");
        return false;
    }

    if (foto.files.length > 0) {

        let file = foto.files[0];

        let ekstensi = file.name.split('.').pop().toLowerCase();

        let allowed = ['jpg', 'jpeg', 'png'];

        if (!allowed.includes(ekstensi)) {
            alert("File harus berupa JPG, JPEG, atau PNG!");
            return false;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert("Ukuran file maksimal 2 MB!");
            return false;
        }
    }

    return true;
}

</script>

</body>
</html>