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

    $sql = "insert into j_jual(no_faktur,jumlah,barang_id,harga,discountp,discountn,colly,satuan,harga_beli,harga_dasar,gudang,subtotal,comp_id,harga_tipe,createby,profit,hpp,ket,ket2,no)
    values('".$no_faktur."','".$val_data['jumlah']."','".$val_data['barang']."','".$val_data['harga_jual']."','".$discpersen."','".$discrupiah."','".$val_data['colly']."','".$val_data['idbarang']."','".$val_data['harga_beli']."','".$val_data['harga_dasar']."','".$gudang."','".$val_data['subtotal']."','10','".$val_data['harga_dasar']."','fauzan','".$profit."','".$val_data['harga_dasar']."','".$val_data['ket']."','".$val_data['ket_so']."','$no')";
    
    $sql_insert = $db->insert($sql, true);

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