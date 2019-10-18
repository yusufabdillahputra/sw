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
$id_gudang = '01';
$id_barang = 'TMN075';
$cust_id   = 'SRK009';

$sql = "DECLARE
@ls_satuan TEXT, @nm_satuan TEXT, @spek_colly TEXT, @idb_stok_update NUMERIC(10,2), @idb_stok_min INT, @ls_tipeharga TEXT, @ls_namabrg TEXT,
@li_nourut INT, @idb_harga_beli NUMERIC(10,2), @idb_harga_dasar NUMERIC(10,2), @li_konversi NUMERIC(8,2), @idb_harga_jual NUMERIC(10,2)

select @ls_satuan = satuan, @idb_stok_update = jumlah, @idb_stok_min = stok_min
from barang_gdg where barang = '$id_barang' and gudang = '$id_gudang'

select @nm_satuan = nama from satuan where id = @ls_satuan

select @ls_tipeharga = kode_tipe from customer where id = '$cust_id'

select @li_nourut = no_urut, @idb_harga_beli = harga_beli, @idb_harga_dasar = harga_dasar, @li_konversi = konversi
from barang_sat where id = '$id_barang' and satuan = @ls_satuan

select @idb_harga_jual = harga
from barang_harga where barang = '$id_barang' and kode_tipe = @ls_tipeharga and satuan = @ls_satuan and aktif = 'Y'

select @ls_namabrg = nama, @spek_colly = percolly from barang where id = '$id_barang'

SELECT @ls_satuan AS id_satuan, @nm_satuan AS nm_satuan, @ls_namabrg AS nm_barang, STRING(@spek_colly, ' ', @nm_satuan) AS spesifikasi, @idb_stok_update AS stok_update, @idb_stok_min AS stok_min, @ls_tipeharga AS tipe_harga,
@li_nourut AS no_urut, @idb_harga_beli AS harga_beli, @idb_harga_dasar AS harga_dasar, @li_konversi AS konversi, @idb_harga_jual AS harga_jual";

$result = $db->first($sql, false);

print("<pre>".print_r($result,true)."</pre>");

$no_faktur = str_replace('/', '', '10/0001/1019/01/JB');

$sql2 = "select * from master_jual where no_faktur = '$no_faktur'";
$result2 = $db->first($sql2, false);

print("<br><pre>".print_r($result2,true)."</pre>");

$sql3 = "select * from j_jual where no_faktur = '$no_faktur'";
$result3 = $db->get($sql3, false);

print("<br><pre>".print_r($result3,true)."</pre>");

$sql4 = "SELECT MAX(no) AS max_no FROM j_jual WHERE no_faktur = '$no_faktur'";
$result4 = $db->first($sql4, false);

$varmaxno = $result4['max_no']+1;

for ($i=1; $i < 4; $i++) { 
	echo ($varmaxno+$i-1);
	echo "<br>";
}