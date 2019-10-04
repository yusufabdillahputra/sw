<?php
/**
 * Autoload (Wajib include di semua CRUD)
 */
spl_autoload_register(function ($class_name) {
    $php_self_exp = explode('/', $_SERVER['PHP_SELF']);
    require_once $_SERVER['DOCUMENT_ROOT'] . '/'.$php_self_exp[1].'/config/system/' . $class_name . '.php';
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
//$codeigniter = new Codeigniter();
$eloquent = new Eloquent();

/**
 * Proses CRUD
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

$datum = [
    'no_faktur' => $no_faktur,
    'gudang' => $gudang,
    'cust_id' => $customer,
    'tanggal' => $tanggal,
    'kendaraan' => $mobil,
    'sales_id' => $salesman,
    'status' => $status,
    'kode_tipe' => $kode_tipe,
    'jth_tempo' => $tgl_jth_tempo,
    'total' => $total,
    'discountp' => $dtdiskonpersen,
    'discountn' => $dtdiskonrp,
    'grandtotal' => $grandtotal,
    'ket' => $keterangan,
    'tipe' => 'J',
    'issuedby' => 'fauzan',
    'flag_hrgtipe' => '1',
    'profit' => $profit,
    'hpp' => $hpp
];

$sql_insert = $eloquent->query()->table('master_jual')->insert($datum);

print json_encode($datum);
?>