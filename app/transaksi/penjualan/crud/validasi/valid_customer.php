<?php
/**
 * Autoload (Wajib include di semua CRUD)
 */
spl_autoload_register(function ($class_name) {
    $php_self_exp = explode('/', $_SERVER['PHP_SELF']);
    include($_SERVER['DOCUMENT_ROOT'] . '/'.$php_self_exp[1].'/config/system/' . $class_name . '.php');
});

/**
 * Path : root_path/config/SQLAnywhere
 */
$db = new SQLAnywhere();

/**
 * Proses CRUD
 * Contoh : $db->rawSql('sql_script', 'json_condition', 'result_type')
 *
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */

if (isset($_POST['customer_id'])) {
    $customer_id = htmlspecialchars($_POST['customer_id']);

    $sql = "declare @ldb_piutang DOUBLE, @ldb_plafon DOUBLE, @ls_prioritas TEXT, @li_fkt_outstanding INT, @is_fkt_outstanding TEXT, @li_faktur INT

SELECT @ldb_piutang = piutang, @ldb_plafon = plafon, @ls_prioritas = prioritas, @li_fkt_outstanding = fkt_outstanding FROM customer where id = '$customer_id'
SELECT @is_fkt_outstanding = fkt_outstanding FROM autority where user_id = 'fauzan'
SELECT @li_faktur = count(no_faktur) FROM master_jual WHERE cust_id = '$customer_id' AND grandtotal <> bayar

select @ldb_piutang as ldb_piutang, @ldb_plafon as ldb_plafon, @ls_prioritas as ls_prioritas, @li_fkt_outstanding as li_fkt_outstanding, @is_fkt_outstanding AS is_fkt_outstanding, @li_faktur AS li_faktur";

    $result = $db->get($sql, false);

    foreach ($result as $value) {
        $ldb_piutang = $value['ldb_piutang'];
        $ldb_plafon = $value['ldb_plafon'];
        $ls_prioritas = $value['ls_prioritas'];
        $li_fkt_outstanding = $value['li_fkt_outstanding'];
        $is_fkt_outstanding = $value['is_fkt_outstanding'];
        $li_faktur = $value['li_faktur'];
    }

    if ($ls_prioritas <> '1' && $is_fkt_outstanding = 'N') {
        if ($li_faktur >= $li_fkt_outstanding) {
            $pesan = "Customer ini mempunyai ".$li_faktur." faktur outstanding. dan faktur outstanding yang diperbolehkan hanya ".$li_fkt_outstanding.".";
            $status = array(
                'code' => 200,
                'status' => true,
                'message' => $pesan
            );
        } else {
            $status = array(
                'code' => 200,
                'status' => false
            );
        }
    }

    print json_encode($status);

}