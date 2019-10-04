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
 
$query = $codeigniter->query()->select('id, name')->from('gudang')->where("id <> '%'")->get()->result_array();

$result = array();
foreach ($query as $row) {
    array_push($result, [
				'id'          => $row['id'],
				'nama_gudang' => $row['name']
    ]);
}

print json_encode($result);