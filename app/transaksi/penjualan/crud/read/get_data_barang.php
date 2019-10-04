<?php
/**
 * Autoload (Wajib include di semua CRUD)
 */
spl_autoload_register(function ($class_name) {
    $php_self_exp = explode('/', $_SERVER['PHP_SELF']);
    include($_SERVER['DOCUMENT_ROOT'] . '/' . $php_self_exp[1] . '/config/system/' . $class_name . '.php');
});

/**
 * Path : root_path/config/SQLAnywhere
 */
$db = new SQLAnywhere();

/**
 * Proses CRUD
 * Contoh : $db->get('sql_script', 'json_condition', 'result_type')
 *
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */



if (isset($_POST['tipe_harga'])) {
    $tipe_harga = htmlspecialchars($_POST['tipe_harga']);
    $id_barang = htmlspecialchars($_POST['id_barang']);

    $sql = "SELECT barang.*, satuan.*, STRING(barang.percolly, ' ', satuan.nama) as spesifikasi, (select nama from satuan where id = barang_gdg.satuan) as satuan_barang,
    (select harga_beli from barang_sat where id = barang.ID and satuan = barang_gdg.satuan) as sat_harga_beli,
    (select harga_dasar from barang_sat where id = barang.ID and satuan = barang_gdg.satuan) as sat_harga_dasar,
    (select harga from barang_harga where kode_tipe = '$tipe_harga' and barang = barang.ID and satuan = barang_gdg.satuan) as set_harga_jual
    FROM barang, satuan, barang_gdg 
    where barang.satuan_id=satuan.id and barang.ID = barang_gdg.barang and barang.ID = '$id_barang'";
    $fetch = $db->get($sql, false);

    $result = array(
        'barang'        => $fetch[0]['ID'],
        'productname'   => $fetch[0]['NAMA'],
        'nama_satuan'   => $fetch[0]['nama'],
        'harga_beli'    => $fetch[0]['sat_harga_beli'],
        'harga_dasar'   => $fetch[0]['sat_harga_dasar'],
        'harga_jual'    => $fetch[0]['set_harga_jual'],
        'spesifikasi'   => $fetch[0]['spesifikasi'],
        'satuan_barang' => $fetch[0]['satuan_barang'],
        'id_barang'     => $fetch[0]['id'],
        'tipe_harga'    => $tipe_harga
    );

    print json_encode($result);
}
