<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Peminjaman.class.php");
include("includes/Buku.class.php");
include("includes/Member.class.php");

// buat objek yang dibutuhkan
$peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$peminjaman->open();
$peminjaman->getPeminjaman();
$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$buku->open();
$buku->getBuku();
$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

$status = false;
$alert = null;

if (isset($_POST['add'])) {
    //memanggil add
    $peminjaman->add($_POST);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_hapus'])) {
    //memanggil delete
    $id = $_GET['id_hapus'];

    $peminjaman->delete($id);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_edit'])) {
    //memanggil statusPeminjaman
    $id = $_GET['id_edit'];

    $peminjaman->statusPeminjaman($id);
    header("location:peminjaman.php");
}

$data = null;
$dataBuku = null;
$dataPeminjam = null;
$no = 1;

// menampilkan data peminjaman
while (list($id, $nim, $nama, $id_buku, $judul_buku, $status) = $peminjaman->getResult()) {
    if ($status == "Sudah Dikembalikan") {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $nim . "</td>
            <td>" . $nama . "</td>
            <td>" . $id_buku . "</td>
            <td>" . $judul_buku . "</td>
            <td>" . $status . "</td>
            <td>
            <a href='peminjaman.php?id_hapus=" . $id . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
    else {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $nim . "</td>
            <td>" . $nama . "</td>
            <td>" . $id_buku . "</td>
            <td>" . $judul_buku . "</td>
            <td>" . $status . "</td>
            <td>
            <a href='peminjaman.php?id_hapus=" . $id . "' class='btn btn-danger' '>Hapus</a>
            <a href='peminjaman.php?id_edit=" . $id .  "' class='btn btn-warning' '>Edit</a>
            </td>
            </tr>";
    }
}

// proses menampilkan daftar buku dan member
while (list($id, $judul, $penerbit, $deskripsi, $status, $id_author) = $buku->getResult()) {
    $dataBuku .= "<option value='".$id."'>".$judul."</option>
                ";
}
while (list($nim, $nama, $jurusan) = $member->getResult()) {
    $dataPeminjam .= "<option value='".$nim."'>".$nama."</option>
                ";
}

$buku->close();
$peminjaman->close();
$member->close();
$tpl = new Template("templates/peminjaman.html");
$tpl->replace("OPTIONBUKU", $dataBuku);
$tpl->replace("OPTIONPEMINJAM", $dataPeminjam);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
