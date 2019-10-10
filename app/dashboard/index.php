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
$sql = "declare @ldb_piutang DOUBLE, @ldb_plafon DOUBLE, @ls_prioritas TEXT, @li_fkt_outstanding INT, @is_fkt_outstanding TEXT, @is_simpan TEXT

SELECT @ldb_piutang = piutang, @ldb_plafon = plafon, @ls_prioritas = prioritas, @li_fkt_outstanding = fkt_outstanding FROM customer where id = '001'
SELECT @is_fkt_outstanding = fkt_outstanding, @is_simpan = simpan FROM autority where user_id = 'fauzan'

select @ldb_piutang as ldb_piutang, @ldb_plafon as ldb_plafon, @is_simpan AS is_simpan";

$result = $db->first($sql, false);

$ldb_total_piutang = $result['ldb_piutang'] + 200000; // 200000 adalah grandtotal dari header
$ldb_plafon        = $result['ldb_plafon'];
$is_simpan         = $result['is_simpan'];
$status            = 'K'; // K = Kredit or T = Tunai --> status pada header insert penjualan
$MessageBox        = "";

if ($status == 'K') {
	if ($ldb_total_piutang >= $ldb_plafon) {
		if ($is_simpan == 'N') {
			$MessageBox = nl2br("Anda tidak mempunyai otoritas untuk membuat transaksi ini karena\r\npiutang customer telah melewati plafon kredit yang diperbolehkan!\r\nPlafon kredit = ".number_format($ldb_plafon, 2, '.', ',')." \r\nJumlah kredit (termasuk faktur ini) = ".number_format($ldb_total_piutang, 2, '.', ','));
		} else {
			$MessageBox = nl2br("Piutang customer telah melewati plafon kredit yang diperbolehkan!\r\nPlafon kredit = ".number_format($ldb_plafon, 2, '.', ',')." \r\nJumlah kredit (termasuk faktur ini) = ".number_format($ldb_total_piutang, 2, '.', ','));
		}
	}
}

print_r($MessageBox);