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
 * Contoh : $db->get('sql_script', 'json_condition', 'result_type')
 *
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */

$dtno_faktur     = addslashes($_REQUEST['no_faktur']);
$no_faktur       = str_replace('/', '', $dtno_faktur);

$gudang          = addslashes($_REQUEST['gudang']);
$customer        = addslashes($_REQUEST['customer']);

$dttanggal       = addslashes($_REQUEST['tanggal']);
$tanggal         = date("Y-m-d", strtotime($dttanggal));

$mobil           = addslashes($_REQUEST['mobil']);
$salesman        = addslashes($_REQUEST['salesman']);
$status          = addslashes($_REQUEST['status']);
$kode_tipe       = addslashes($_REQUEST['kode_tipe']);

$dttgl_jth_tempo = addslashes($_REQUEST['tgl_jth_tempo']);
$dtdate          = str_replace('/','-', $dttgl_jth_tempo);
$tgl_jth_tempo   = date("Y-m-d", strtotime($dtdate));

$total           = addslashes($_REQUEST['total']);
$diskonpersen    = addslashes($_REQUEST['diskonpersen']);
if ($diskonpersen == '' || $diskonpersen == NULL) {
    $dtdiskonpersen = 0.00;
} else {
    $dtdiskonpersen = $diskonpersen;
}

$diskonrp        = addslashes($_REQUEST['diskonrp']);
if ($diskonrp == '' || $diskonrp == NULL) {
    $dtdiskonrp = 0.00;
} else {
    $dtdiskonrp = $diskonrp;
}

$grandtotal = addslashes($_REQUEST['grandtotal']);
$keterangan = addslashes($_REQUEST['keterangan']);

$hpp        = addslashes($_REQUEST['hpp']);
$profit     = addslashes($_REQUEST['profit']);

$sql = "insert into master_jual(no_faktur,gudang,cust_id,tanggal,kendaraan,sales_id,status,kode_tipe,jth_tempo,total,discountp,discountn,grandtotal,ket,tipe,issuedby,flag_hrgtipe,profit,hpp) values('$no_faktur','$gudang','$customer','$tanggal','$mobil','$salesman','$status','$kode_tipe','$tgl_jth_tempo','$total','$dtdiskonpersen','$dtdiskonrp','$grandtotal','$keterangan','J','fauzan','1','$profit','$hpp')";

$sql_insert = $db->insert($sql, true);

if ($sql_insert) {
    echo json_encode(
        array(
            'no_faktur'     => $no_faktur,
            'gudang'        => $gudang,
            'customer'      => $customer,
            'tanggal'       => $dttanggal,
            'mobil'         => $mobil,
            'salesman'      => $salesman,
            'status'        => $status,
            'kode_tipe'     => $kode_tipe,
            'tgl_jth_tempo' => $dttgl_jth_tempo,
            'total'         => $total,
            'diskonpersen'  => $diskonpersen,
            'diskonrp'      => $diskonrp,
            'grandtotal'    => $grandtotal,
            'keterangan'    => $keterangan,
            'hpp'           => $hpp,
            'profit'        => $profit
        )
    );
} else {
    echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>