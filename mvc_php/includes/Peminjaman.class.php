<?php

class Peminjaman extends DB
{
    function getPeminjaman()
    {
        $query = "SELECT peminjaman.id_peminjaman, member.nim, member.nama, buku.id_buku, buku.judul_buku, peminjaman.status
                    FROM peminjaman JOIN member ON peminjaman.nim = member.nim
                    JOIN buku ON peminjaman.id_buku = buku.id_buku";
        return $this->execute($query);
    }

    function add($data)
    {
        $nim = $data['cmbpeminjam'];
        $id_buku = $data['cmbbuku'];

        $query = "insert into peminjaman values ('', '$nim', '$id_buku', 'Belum Dikembalikan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "DELETE FROM peminjaman WHERE id_peminjaman = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function statusPeminjaman($id)
    {

        $status = "Sudah Dikembalikan";
        $query = "UPDATE peminjaman SET status = '$status' where id_peminjaman = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
