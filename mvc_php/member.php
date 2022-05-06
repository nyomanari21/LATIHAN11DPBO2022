<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();
$prosesedit = 0;

if (isset($_POST['add'])) {
    //memanggil add
    $member->add($_POST);
    header("location:member.php");
}

if (isset($_POST['edit'])) {
    // memanggil edit member
    $member->editMember($_POST);
    header("location:member.php");
}

//mengecek apakah ada id_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus'])) {
    //memanggil delete
    $id = $_GET['id_hapus'];

    $member->delete($id);
    header("location:member.php");
}

// mengecek apakah ada id_edit
if (!empty($_GET['id_edit'])) {
    // tandai sedang dalam proses edit
    $prosesedit = 1;

    // membuat dan mengambil data member yang akan diedit
    $memberedit = new Member($db_host, $db_user, $db_pass, $db_name);
    $memberedit->open();
    $memberedit->getSpecificMember($_GET['id_edit']);
}

$dataNim = null;
$dataNama = null;
$dataJurusan = null;
$data = null;
$no = 1;

while (list($nim, $nama, $jurusan) = $member->getResult()) {
    $data .= "<tr>
                <td>" . $no++ . "</td>
                <td>" . $nim . "</td>
                <td>" . $nama . "</td>
                <td>" . $jurusan . "</td>
                <td>
                <a href='member.php?id_edit=" . $nim .  "' class='btn btn-warning''>Edit</a>
                <a href='member.php?id_hapus=" . $nim . "' class='btn btn-danger''>Hapus</a>
                </td>
                </tr>";
}

$member->close();
$tpl = new Template("templates/member.html");
$tpl->replace("DATA_TABEL", $data);

// jika dalam proses edit
if($prosesedit == 1){
    while (list($nim, $nama, $jurusan) = $memberedit->getResult()) {
        $dataNim .= "value='$nim'";
        $dataNama .= "value='$nama'";
        $dataJurusan .= "value='$jurusan'";
    }
    $tpl->replace("DATA_NIM", $dataNim);
    $tpl->replace("DATA_NAMA", $dataNama);
    $tpl->replace("DATA_JURUSAN", $dataJurusan);
    $tpl->replace("JUDUL", "Ubah");
    $tpl->replace("TOMBOL", "Edit");
    $tpl->replace("FORMNIM1", "readnim");
    $tpl->replace("FORMNIM2", "tnim");
    $tpl->replace("READONLY", "disabled readonly");
    $tpl->replace("FORMMEMBER", "edit");
    $memberedit->close();
}
// jika tidak
else{
    $tpl->replace("JUDUL", "Input");
    $tpl->replace("TOMBOL", "Add");
    $tpl->replace("DATA_NIM", "value=''");
    $tpl->replace("DATA_NAMA", $dataNama);
    $tpl->replace("DATA_JURUSAN", $dataJurusan);
    $tpl->replace("FORMNIM1", "tnim");
    $tpl->replace("FORMNIM2", "readnim");
    $tpl->replace("READONLY", "");
    $tpl->replace("FORMMEMBER", "add");
}
$tpl->write();
