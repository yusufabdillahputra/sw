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

if (isset($_POST['gudang']) AND isset($_POST['tgl_mulai']) AND isset($_POST['tgl_akhir'])) {
    $gudang    = htmlspecialchars($_POST['gudang']);
    $tgl_mulai = htmlspecialchars($_POST['tgl_mulai']);
    $tgl_akhir = htmlspecialchars($_POST['tgl_akhir']);

    $EXP_tgl_mulai = explode('/', $tgl_mulai);
    $EXP_tgl_akhir = explode('/', $tgl_akhir);
    $tgl_mulai_db  = $EXP_tgl_mulai[2].'-'.$EXP_tgl_mulai[1].'-'.$EXP_tgl_mulai[0];
    $tgl_akhir_db  = $EXP_tgl_akhir[2].'-'.$EXP_tgl_akhir[1].'-'.$EXP_tgl_akhir[0];

    $sql = "SELECT tanggal, no_faktur, modifydate, cetak, flag_hrgtipe FROM master_jual where tanggal between '$tgl_mulai_db' and '$tgl_akhir_db' and gudang = '$gudang'";
    $fetch = $db->get($sql, false);

    $result = array();
    foreach ($fetch as $row) {
        $nf  = $row['no_faktur'];
        $f1  = substr($nf, 0, -12);
        $f2  = substr($nf, 2, -8);
        $f3  = substr($nf, 6, -4);
        $f4  = substr($nf, 10, -2);
        $f5  = substr($nf, 12);
        
        $md  = $row['modifydate'];
        $smd = substr($md, 0, -13);

        if ($row['cetak'] == 'Y' and $row['flag_hrgtipe'] == 0) {
            $color_modifydate = 'blue';
            $color_no_faktur  = 'black';
        } elseif ($row['cetak'] == 'Y' and $row['flag_hrgtipe'] == 1) {
            $color_modifydate = 'blue';
            $color_no_faktur  = 'red';
        } elseif ($row['cetak'] == 'N' and $row['flag_hrgtipe'] == 1) {
            $color_modifydate = 'black';
            $color_no_faktur  = 'red';
        } else {
            $color_modifydate = 'black';
            $color_no_faktur  = 'black';
        }
        $background = 'white';

        array_push($result, [
            'color_modifydate' => $color_modifydate,
            'color_no_faktur'  => $color_no_faktur,
            'background'       => $background,
            'modifydate'       => $smd,
            'no_faktur'        => "$f1/$f2/$f3/$f4/$f5",
            'no_faktur_db'     => $row['no_faktur']
        ]);
    }
    print json_encode($result);
}
