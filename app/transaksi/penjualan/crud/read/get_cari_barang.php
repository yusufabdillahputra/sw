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

if (isset($_POST['cust_id'])) {
    $cust_id = htmlspecialchars($_POST['cust_id']);
    $id_gudang = htmlspecialchars($_POST['id_gudang']);

    $sql = "declare @tipe_harga TEXT

            select @tipe_harga = kode_tipe from customer where id = '$cust_id'

            select top 120
                brg.ID, 
                brg.NAMA, 
                sat.harga_beli, 
                sat.harga_dasar, 
                hrg.harga as harga_jual,
                gdg.jumlah,
                st.nama,
                STRING(brg.percolly,' ',st.nama) as spesifikasi
            from barang_sat as sat 
            left join barang_gdg as gdg 
                on sat.id = gdg.barang
                and sat.satuan = gdg.satuan
            left join barang as brg
                on brg.id = gdg.barang
            left join satuan as st
                on gdg.satuan = st.id
            left join barang_harga as hrg
                on brg.id = hrg.barang
            where
                gdg.gudang = '$id_gudang'
            and brg.status = '1'
            and hrg.kode_tipe = @tipe_harga
            order by
                brg.NAMA asc";
    $fetch = $db->get($sql, false);

    $result = array();
    foreach ($fetch as $row) {
        array_push($result, [
            'id_barang'     => $row['ID'],
            'nama_barang'   => $row['NAMA'],
            'harga_beli'    => $row['harga_beli'],
            'harga_dasar'   => $row['harga_dasar'],
            'harga_jual'    => $row['harga_jual'],
            'jumlah'        => $row['jumlah'],
            'satuan_barang' => $row['nama'],
            'spesifikasi'   => $row['spesifikasi']
        ]);
    }

    print json_encode($result);
}
