<?php
/**
 * Autoload (Wajib include di semua CRUD)
 */
spl_autoload_register(function ($class_name) {
    $php_self_exp = explode('/', $_SERVER['PHP_SELF']);
    include($_SERVER['DOCUMENT_ROOT'] . '/'.$php_self_exp[1].'/config/system/' . $class_name . '.php');
});

/**
 * Deklarasi query builder
 * Yang tersedia : 1) Codeigniter Query Builder, DOC : https://codeigniter.com/user_guide/database/query_builder.html
 *                 2) Illuminate Eloquent, DOC : https://laravel.com/docs/5.2/queries
 *
 * Contoh script : 1) $codeigniter::query()->get('nama_tabel')->result();
 *                 2) $eloquent::query()->table('nama_tabel')->get();
 *
 * Info          : Query builder bisa digunakan keduanya atau salah satu, sesuai kebutuhan
 */
$codeigniter = new Codeigniter();
//$eloquent = new Eloquent();

/**
 * Proses CRUD
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */

if (isset($_POST['tipe_harga'])) {
    $tipe_harga = htmlspecialchars($_POST['tipe_harga']);
    $id_barang = htmlspecialchars($_POST['id_barang']);
    
    $query = $codeigniter->query()->query("SELECT barang.*, satuan.*, STRING(barang.percolly, ' ', satuan.nama) as spesifikasi, (select nama from satuan where id = barang_gdg.satuan) as satuan_barang,
    (select harga_beli from barang_sat where id = barang.ID and satuan = barang_gdg.satuan) as sat_harga_beli,
    (select harga_dasar from barang_sat where id = barang.ID and satuan = barang_gdg.satuan) as sat_harga_dasar,
    (select harga from barang_harga where kode_tipe = '$tipe_harga' and barang = barang.ID and satuan = barang_gdg.satuan) as set_harga_jual
    FROM barang, satuan, barang_gdg 
    where barang.satuan_id=satuan.id and barang.ID = barang_gdg.barang and barang.ID = '$id_barang'");
    $row = $query->row_array();

    $result = array(
        'barang'        => $row['ID'],
        'productname'   => $row['NAMA'],
        'nama_satuan'   => $row['nama'],
        'harga_beli'    => $row['sat_harga_beli'],
        'harga_dasar'   => $row['sat_harga_dasar'],
        'harga_jual'    => $row['set_harga_jual'],
        'spesifikasi'   => $row['spesifikasi'],
        'satuan_barang' => $row['satuan_barang'],
        'id_barang'     => $row['id'],
        'tipe_harga'    => $tipe_harga
    );
    echo json_encode($result);
}
