<?php
if (isset($_POST['tipe_harga'])) {
    $tipe_harga = htmlspecialchars($_POST['tipe_harga']);
    $id_barang = htmlspecialchars($_POST['id_barang']);
    $conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");
    $sql = "SELECT barang.*, satuan.*, STRING(barang.percolly, ' ', satuan.nama) as spesifikasi, (select nama from satuan where id = barang_gdg.satuan) as satuan_barang,
    (select harga_beli from barang_sat where id = barang.ID and satuan = barang_gdg.satuan) as sat_harga_beli,
    (select harga_dasar from barang_sat where id = barang.ID and satuan = barang_gdg.satuan) as sat_harga_dasar,
    (select harga from barang_harga where kode_tipe = '$tipe_harga' and barang = barang.ID and satuan = barang_gdg.satuan) as set_harga_jual
    FROM barang, satuan, barang_gdg 
    where barang.satuan_id=satuan.id and barang.ID = barang_gdg.barang and barang.ID = '$id_barang'";
    $query = sasql_query($conn, $sql);
    $row = sasql_fetch_array($query);
    $result = array(
        'barang' => $row['ID'],
        'productname' => $row['NAMA'],
        'nama_satuan' => $row['nama'],
        'harga_beli' => $row['sat_harga_beli'],
        'harga_dasar' => $row['sat_harga_dasar'],
        'harga_jual' => $row['set_harga_jual'],
        'spesifikasi' => $row['spesifikasi'],
        'satuan_barang' => $row['satuan_barang'],
        'id_barang' => $row['id'],
        'tipe_harga' => $tipe_harga
    );
    echo json_encode($result);
}
