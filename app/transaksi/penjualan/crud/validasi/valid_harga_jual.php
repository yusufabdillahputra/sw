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
$library = new Library();

/**
 * Proses CRUD
 * Contoh : $db->rawSql('sql_script', 'json_condition', 'result_type')
 *
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */

if (isset($_POST['ll_rc2'])) {
    $ll_rc2 = htmlspecialchars($_POST['ll_rc2']);
    $jumlah = $_POST['jumlah'];
    $harga_dasar = $_POST['harga_dasar'];
    $subtotal = $_POST['subtotal'];
    $nama_barang = $_POST['nama_barang'];
    $id_customer = htmlspecialchars($_POST['id_customer']);

    $sql = "select simpan from autority where user_id = 'fauzan'";

    $result = $db->first($sql, false);
    $simpan = $result['simpan'];

    if ($simpan == 'N') {
        $cekPlafon = $library->fCekPlafoncust($id_customer);
        if ($cekPlafon == 5) {
            $status = array(
                'code' => 401,
                'pesan' => "Anda tidak mempunyai otoritas untuk membuat faktur over plafon."
            );
            print json_encode($status);
        } else {
            $ls_namabrg = array();
            for ($i = 0; $i < $ll_rc2; $i++) {
                $ldb_jumlah = $jumlah[$i];
                $ldb_hrgdasar = $harga_dasar[$i];

                $ldb_hrgsubtotal = (int)$subtotal[$i];
                $ldb_subtot_hrgdasar = $ldb_hrgdasar * $ldb_jumlah;
                /**
                 * todo : Kenapa nama barang tidak bisa di filter sesuai logika dibawah
                 */
//                if ($ldb_hrgsubtotal <= $ldb_subtot_hrgdasar) {
//                    array_push($ls_namabrg, $nama_barang[$i]);
//                }
                array_push($ls_namabrg, $nama_barang[$i]);
            }
            $str_nama_barang = implode(',', $ls_namabrg);
            $status = array(
                'code' => 406,
                'pesan' => "Harga jual barang <b>" . strtoupper($str_nama_barang) . "</b> lebih kecil dari harga dasar.\n Anda tidak mempunyai hak akses untuk menyimpan transaksi penjualan ini."
            );
            print json_encode($status);
        }
    }
    if ($simpan == 'Y') {
        $status = array(
            'code' => 200,
            'pesan' => 'OK'
        );
        print json_encode($status);
    }

}