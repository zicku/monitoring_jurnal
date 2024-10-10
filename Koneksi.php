<?php
    $koneksi = mysqli_connect("localhost", "monito29_admin", "monito29_admin", "monito29_db");

    if(mysqli_connect_errno())
    {
        echo "Koneksi Gagal ". mysqli_connect_error();
    }
?>