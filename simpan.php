<?php
include 'koneksi.php';

$id = $_POST['id'];
$nim = $_POST['nim'];
$nama = $_POST['nama_lengkap'];
$jurusan = $_POST['jurusan'];
$foto_lama = $_POST['foto_lama'];

$namaFoto = $foto_lama;

if ($_FILES['foto']['name'] != "") {

    $fileName = $_FILES['foto']['name'];
    $tmpName = $_FILES['foto']['tmp_name'];
    $size = $_FILES['foto']['size'];

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png'];

    if (!in_array($ext, $allowed)) {
        die("Format file tidak didukung!");
    }

    if ($size > 2 * 1024 * 1024) {
        die("Ukuran file terlalu besar!");
    }

    $namaFoto = time() . "_" . uniqid() . "." . $ext;

    move_uploaded_file($tmpName,
        "uploads/" . $namaFoto);

    if ($foto_lama != "" &&
        file_exists("uploads/" . $foto_lama)) {

        unlink("uploads/" . $foto_lama);
    }
}

if ($id == "") {

    mysqli_query($conn,
        "INSERT INTO mahasiswa
        (nim, nama_lengkap, jurusan, foto)
        VALUES
        ('$nim','$nama','$jurusan','$namaFoto')");

    echo "
    <script>
        alert('Data berhasil ditambahkan!');
        window.location='index.php';
    </script>
    ";

} else {

    mysqli_query($conn,
        "UPDATE mahasiswa SET
        nim='$nim',
        nama_lengkap='$nama',
        jurusan='$jurusan',
        foto='$namaFoto'
        WHERE id='$id'");

    echo "
    <script>
        alert('Data berhasil diupdate!');
        window.location='index.php';
    </script>
    ";
}
?>