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

if (isset($_POST['dtno_faktur'])) {
	$dtno_faktur = htmlspecialchars($_POST['dtno_faktur']);
	$no_faktur = str_replace('/', '', htmlspecialchars($_POST['dtno_faktur']));

	$sql = "SELECT 
                jual.*,
                gdg.name as nama_gdg,
                cst.nama as nama_cust,
                mbl.nama as nama_mobil,
                pgw.nama as nama_sales,
                hrg.nama_tipe
            FROM
                master_jual as jual
                LEFT JOIN gudang as gdg
                    ON jual.gudang = gdg.id
                LEFT JOIN customer as cst
                    ON jual.cust_id = cst.id
                LEFT JOIN mobil as mbl
                    ON jual.kendaraan = mbl.id
                LEFT JOIN pegawai as pgw
                    ON jual.sales_id = pgw.id
                LEFT JOIN tipe_harga as hrg
                    ON jual.kode_tipe = hrg.kode_tipe
            WHERE jual.no_faktur = '$no_faktur'";
	$result = $db->first($sql, false);

	$header = array();
	array_push($header, [
		'no_faktur'     => $dtno_faktur,
		'gudang_id'     => $result['gudang'],
		'nama_gudang'   => $result['nama_gdg'],
		'customer_id'   => $result['cust_id'],
		'nama_customer' => $result['nama_cust'],
		'tanggal'       => $result['tanggal'],
		'mobil_id'      => $result['kendaraan'],
		'nama_mobil'    => $result['nama_mobil'],
		'sales_id'      => $result['sales_id'],
		'salesman'      => $result['nama_sales'],
		'status'        => $result['status'],
		'kode_tipe'     => $result['kode_tipe'],
		'tipe_harga'    => $result['nama_tipe'],
		'tgl_jthtempo'  => $result['jth_tempo'],
		'total'         => $result['total'],
		'discountp'     => $result['discountp'],
		'discountn'     => $result['discountn'],
		'grandtotal'    => $result['grandtotal'],
		'keterangan'    => $result['ket']
	]);

    $sql_body = "SELECT 
                j_jual.jumlah,
                satuan.nama as 'satuan',
                j_jual.barang_id,
                Barang.Nama as 'productname',
                STRING(Barang.percolly,' ',satuan.nama) as 'spesifikasi',
                j_jual.harga_beli,
                j_jual.harga_dasar,
                j_jual.harga,
                j_jual.discountp,
                j_jual.discountn,
                j_jual.subtotal,
                j_jual.colly,
                j_jual.ket2,
                j_jual.profit,
                j_jual.barang_id
            FROM
                j_jual
                LEFT JOIN Barang ON j_jual.barang_id = Barang.ID
                LEFT JOIN satuan ON j_jual.satuan = satuan.id
            WHERE j_jual.no_faktur = '$no_faktur'";
    $result_body = $db->get($sql_body, false);

    $body = array();
    foreach ($result_body as $row) {
        array_push($body, array(
            'no_faktur'     => $dtno_faktur,
            'jumlah' => $row['jumlah'],
            'satuan' => $row['satuan'],
            'productname' => $row['productname'],
            'spesifikasi' => $row['spesifikasi'],
            'harga_beli' => $row['harga_beli'],
            'harga_dasar' => $row['harga_dasar'],
            'harga_jual' => $row['harga'],
            'discpersen' => $row['discountp'],
            'discrupiah' => $row['discountn'],
            'subtotal' => $row['subtotal'],
            'colly' => $row['colly'],
            'ket_so' => $row['ket2'],
            'data_profit' => $row['profit'],
            'barang_id' => $row['barang_id'],
        ));
    }



	$status = array(
	    'header' => $header[0],
        'body' => $body
    );
	print json_encode($status);
}