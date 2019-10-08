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
$library = new Library();

/**
 * Proses CRUD
 * Contoh : $db->rawSql('sql_script', 'json_condition', 'result_type')
 *
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */
$sql = "select simpan from autority where user_id = 'fauzan'";

$result = $db->first($sql, false);
$simpan = $result['simpan'];

if ($simpan == 'N') {
    $cekPlafon = $library->fCekPlafoncust('001');
	if ($cekPlafon == 5) {
		echo $MessageBox = "Anda tidak mempunyai otoritas untuk membuat faktur over plafon.";
	} else {
		$ll_rc2 = 2;

		$jumlah = array('2','1');
		$harga_dasar = array('2000','15500');
		$subtotal = array('2000','10000');
		$nama_barang = array('gelas','baskom testing');

		for ($i=0; $i < $ll_rc2; $i++) {
			$ldb_jumlah   = $jumlah[$i];
			$ldb_hrgdasar = $harga_dasar[$i];
			$ldb_hrgsubtotal = $subtotal[$i];
			$ldb_subtot_hrgdasar = $ldb_hrgdasar * $ldb_jumlah;
		}
		if ($ldb_hrgsubtotal <= $ldb_subtot_hrgdasar) {
			$ls_namabrg = $nama_barang[0];
			echo $MessageBox = "Harga jual barang <b>".strtoupper($ls_namabrg)."</b> lebih kecil dari harga dasar.\n Anda tidak mempunyai hak akses untuk menyimpan transaksi penjualan ini.";
		}
	}
}

