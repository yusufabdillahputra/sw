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
 
$sql = $codeigniter->query()->select("customer.id, customer.nama, customer.kode_tipe, tipe_harga.nama_tipe, dateformat(dateadd(day, customer.payment_due, NOW()),'dd/mm/yyyy') as tgl_jth_tempo, dateformat(NOW(), 'mm/dd/yyyy') as tgl_transaksi")->from('customer')->join('tipe_harga','customer.kode_tipe = tipe_harga.kode_tipe')->get()->result_array();

$result = array();
foreach ($sql as $row) {
        array_push($result, [
						'id'            => $row['id'],
						'nama'          => $row['nama'],
						'kode_tipe'     => $row['kode_tipe'],
						'nama_tipe'     => $row['nama_tipe'],
						'tgl_jth_tempo' => $row['tgl_jth_tempo'],
						'tgl_transaksi' => $row['tgl_transaksi']
        ]);
    }
echo json_encode($result);
?>