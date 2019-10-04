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
//$codeigniter = new Codeigniter();
$eloquent = new Eloquent();

/**
 * Proses CRUD
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */

// hpp = harga jual
// harga tipe = harga
// profit = subtotal - hpp

$dtno_faktur = $_POST['no_faktur'];
$no_faktur   = str_replace('/', '', $dtno_faktur);
$gudang      = $_POST['gudang'];

$data        = $_POST['params'];
$no          = 0;

$table       = 'j_jual';

foreach ($data as $val_data) { $no++;
    $profit = $val_data['subtotal'] - $val_data['harga_dasar'];

    if ($val_data['discpersen'] == '' || $val_data['discpersen'] == NULL) {
        $discpersen = 0.00;
    }else{
        $discpersen = $val_data['discpersen'];
    }

    if ($val_data['discrupiah'] == '' || $val_data['discrupiah'] == NULL) {
        $discrupiah = 0.00;
    }else{
        $discrupiah = $val_data['discrupiah'];
    }

    if ($val_data['colly'] == '' || $val_data['colly'] == NULL) {
        $colly = 0.00;
    } else {
        $colly = $val_data['colly'];
    }

    $nomor       = $no;
    
    $sql_insert = $eloquent->query()->table('j_jual')
            ->insert([
                'no_faktur'   => $no_faktur,
                'jumlah'      => $val_data['jumlah'],
                'barang_id'   => $val_data['barang'],
                'harga'       => $val_data['harga_jual'],
                'discountp'   => $discpersen,
                'discountn'   => $discrupiah,
                'colly'       => $colly,
                'satuan'      => $val_data['idbarang'],
                'harga_beli'  => $val_data['harga_beli'],
                'harga_dasar' => $val_data['harga_dasar'],
                'gudang'      => $gudang,
                'subtotal'    => $val_data['subtotal'],
                'comp_id'     => '10',
                'harga_tipe'  => $val_data['harga_dasar'],
                'createby'    => 'fauzan',
                'profit'      => $profit,
                'hpp'         => $val_data['harga_dasar'],
                'ket'         => $val_data['ket'],
                'ket2'        => $val_data['ket_so'],
                'no'          => $nomor
            ]);

    if ($sql_insert) {
        echo json_encode(
            array(
                'jumlah'      => $val_data['jumlah'],
                'satuan'      => $val_data['idbarang'],
                'barang'      => $val_data['barang'],
                'spesifikasi' => $val_data['spesifikasi'],
                'harga_beli'  => $val_data['harga_beli'],
                'harga_dasar' => $val_data['harga_dasar'],
                'harga_jual'  => $val_data['harga_jual'],
                'discpersen'  => $val_data['discpersen'],
                'discrupiah'  => $val_data['discrupiah'],
                'subtotal'    => $val_data['subtotal'],
                'colly'       => $val_data['colly'],
                'ket'         => $val_data['ket'],
                'ket_so'      => $val_data['ket_so']
            )
        );
    } else {
        echo json_encode(array('errorMsg'=>'Some errors occured.'));
    }
}
?>