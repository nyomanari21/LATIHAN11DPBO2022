<?php

class Member extends DB
{
    function getMember()
    {
        $query = "SELECT * FROM member";
        return $this->execute($query);
    }

    function getSpecificMember($id)
    {
        $query = "SELECT * FROM member WHERE nim = '$id'";
        return $this->execute($query);
    }

    function add($data)
    {
        $nim = $data['tnim'];
        $nama = $data['tnama'];
        $jurusan = $data['tjurusan'];

        $query = "insert into member values ('$nim', '$nama', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM member WHERE nim = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function editMember($data)
    {
        $nim = $data['tnim'];
        $nama = $data['tnama'];
        $jurusan = $data['tjurusan'];

        $query = "UPDATE member SET nama='$nama', jurusan='$jurusan' WHERE nim='$nim'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
