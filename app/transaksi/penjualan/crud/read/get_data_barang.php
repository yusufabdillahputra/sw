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



if (isset($_POST['id_barang'])) {
    $id_barang = htmlspecialchars($_POST['id_barang']);
    $id_cust   = htmlspecialchars($_POST['id_cust']);
    $id_gudang = htmlspecialchars($_POST['id_gudang']);

    $sql = "DECLARE
        @ls_satuan TEXT, 
        @nm_satuan TEXT, 
        @spek_colly TEXT, 
        @idb_stok_update NUMERIC(10,2), 
        @idb_stok_min INT, 
        @ls_tipeharga TEXT, 
        @ls_namabrg TEXT,
        @li_nourut INT, 
        @idb_harga_beli NUMERIC(10,2), 
        @idb_harga_dasar NUMERIC(10,2), 
        @li_konversi NUMERIC(8,2), 
        @idb_harga_jual NUMERIC(10,2)
        
        SELECT 
            @ls_satuan = satuan, 
            @idb_stok_update = jumlah,
            @idb_stok_min = stok_min
        FROM 
            barang_gdg 
        WHERE 
            barang = '$id_barang' 
            AND gudang = '$id_gudang'
        
        SELECT 
            @nm_satuan = nama 
        FROM
            satuan 
        WHERE 
            id = @ls_satuan
        
        SELECT 
            @ls_tipeharga = kode_tipe 
        FROM 
            customer 
        WHERE 
            id = '$id_cust'
        
        SELECT 
            @li_nourut = no_urut, 
            @idb_harga_beli = harga_beli, 
            @idb_harga_dasar = harga_dasar, 
            @li_konversi = konversi
        FROM 
            barang_sat 
        WHERE 
            id = '$id_barang' 
            AND satuan = @ls_satuan
        
        SELECT 
            @idb_harga_jual = harga
        FROM 
            barang_harga 
        WHERE 
            barang = '$id_barang' 
            AND kode_tipe = @ls_tipeharga 
            AND satuan = @ls_satuan 
            AND aktif = 'Y'
        
        SELECT 
            @ls_namabrg = nama, 
            @spek_colly = percolly 
        FROM
            barang 
        WHERE 
            id = '$id_barang'
        
        SELECT 
        @ls_satuan AS id_satuan, 
        @nm_satuan AS satuan_barang, 
        @ls_namabrg AS nm_barang, 
        STRING(@spek_colly, ' ', @nm_satuan) AS spesifikasi, 
        @idb_stok_update AS stok_update, 
        @idb_stok_min AS stok_min, 
        @ls_tipeharga AS tipe_harga,
        @li_nourut AS no_urut, 
        @idb_harga_beli AS sat_harga_beli, 
        @idb_harga_dasar AS sat_harga_dasar, 
        @li_konversi AS konversi, 
        @idb_harga_jual AS set_harga_jual";

    $fetch = $db->first($sql, false);

    $result = array(
        'harga_beli'    => $fetch['sat_harga_beli'],
        'harga_dasar'   => $fetch['sat_harga_dasar'],
        'harga_jual'    => $fetch['set_harga_jual'],
        'spesifikasi'   => $fetch['spesifikasi'],
        'satuan_barang' => $fetch['satuan_barang'],
        'id_barang'     => $fetch['id_satuan']
    );

    print json_encode($result);
}
