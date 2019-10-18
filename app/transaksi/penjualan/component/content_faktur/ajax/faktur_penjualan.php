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

if (isset($_POST['no_faktur_db'])) {

    $no_faktur_db = htmlspecialchars($_POST['no_faktur_db']);
    $no_faktur    = htmlspecialchars($_POST['no_faktur']);

    $customer_sql = "SELECT customer.nama, KOTA.NAMA, mobil.nama as nama_mobil FROM customer join KOTA on customer.kota = KOTA.ID left join master_jual on customer.id = master_jual.cust_id left join mobil on master_jual.kendaraan = mobil.id where master_jual.no_faktur = '$no_faktur_db'";
    $customer = array();

    $customer_query = $db->get($customer_sql, false);
    foreach ($customer_query as $value) {
        array_push($customer, [
                'nama' => $value['nama'],
                'kota' => $value['NAMA'],
                'nama_mobil' => $value['nama_mobil']
            ]);
    }

    $j_jual_sql = "SELECT * FROM j_jual,master_jual,satuan,barang where j_jual.barang_id=barang.ID and master_jual.no_faktur=j_jual.no_faktur and j_jual.satuan=satuan.id and master_jual.no_faktur='$no_faktur_db'";
    $j_jual = array();

    $j_jual_query = $db->get($j_jual_sql, false);
    foreach ($j_jual_query as $value) {
        $jatuh_tempo = $value['jth_tempo'];
        {
            $var  = $jatuh_tempo;
            $date = str_replace('-', '/', $var);
        }

        array_push($j_jual, [
            'jumlah'    => $value['jumlah'],
            'jth_tempo' => $value['jth_tempo'],
            'nama'      => $value['nama'],
            'NAMA'      => $value['NAMA'],
            'disctp'    => $value['discountp'],
            'disctn'    => $value['discountn'],
            'harga'     => $value['harga'],
            'colly'     => $value['colly'],
            'ket'       => $value['ket'],
            'subtot'    => $value['harga'] * $value['jumlah']
        ]);
    }

    $m_jual_sql = "SELECT * FROM master_jual,pegawai where master_jual.sales_id=pegawai.id and master_jual.no_faktur='$no_faktur_db'";
    $m_jual = array();

    $m_jual_query = $db->get($m_jual_sql, false);
    foreach ($m_jual_query as $value) {
        array_push($m_jual, [
            'total'      => $value['total'],
            'nama'       => $value['nama'],
            'issuedby'   => $value['issuedby'],
            'discp'      => $value['discountp'],
            'discn'      => $value['discountn'],
            'grandtotal' => $value['grandtotal']
        ]);
    }
    ?>

    <style>
        .main_table {
            width: 100%;
            font-size: 11px;
            border:0px;

        }
        .main_table td{
            border:0px;
            border:0px;

        }
        .main_table th{
            cellspacing:0;


        }
    </style>
    <table class="main_table">
        <tr>
            <td width="70%" align="center">
                <h1>FAKTUR PENJUALAN</h1>
            </td>
            <td width="*">
                <table class="main_table">
                    <tr>
                        <td colspan="3">Pekanbaru, <?php echo date("d F Y") ?></td>
                    </tr>
                    <tr>
                        <td>Tuan</td>
                        <td>:</td>
                        <td><?= $customer[0]['nama']; ?></td>
                    </tr>
                    <tr>
                        <td>Kota</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Pekanbaru</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table border="0" class="main_table">
        <tr>
            <td width="33%">
                <table class="main_table">
                    <tr>
                        <td width="20%">No Faktur</td>
                        <td width="5%">:</td>
                        <td width="*"><?= $no_faktur; ?></td>
                    </tr>
                </table>
            </td>
            <td width="33%">
                <table class="main_table">
                    <tr>
                        <td width="20%">Mobil</td>
                        <td width="5%">:</td>
                        <td width="*"><?= $customer[0]['nama_mobil']; ?></td>
                    </tr>
                </table>
            </td>
            <td width="33%">
                <table class="main_table">
                    <tr>
                        <td width="30%">Tgl jth. tempo</td>
                        <td width="5%">:</td>
                        <td width="*">  <?php echo date('d F Y', strtotime($date));?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table border="1" class="main_table">
        <thead>
        <tr>
            <th>No</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th width="15%">Barang</th>
            <th>Harga Satuan</th>
            <th>Disc %</th>
            <th>Disc Rp.</th>
            <th>Sub Total</th>
            <th>Colly</th>
            <th>Ket</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($j_jual as $key_array => $data) {
            ?>
            <tr>
                <td align='center' width='1%'><?= $key_array + 1; ?></td>
                <td align='center'><?= number_format($data['jumlah'], 0, '', '.') ?></td>
                <td align='center'><?= $data['nama']; ?></td>
                <td align='center'><?= $data['NAMA']; ?></td>
                <td align='left'><?= number_format($data['harga'], 0, '', '.') ?>,00</td>
                <td align='center'><?= number_format($data['disctp'], 0, '', '.') ?></td>
                <td align='center'><?= number_format($data['disctn'], 0, '', '.') ?></td>
                <td align='left'>&nbsp;&nbsp;<?= number_format($data['subtot'], 0, '', '.') ?>,00</td>
                <td align='center'><?= $data['colly']; ?></td>
                <td><?= $data['ket']; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6">
                <table border="0" class="main_table">
                    <tr>
                        <td width="20%">Salesman</td>
                        <td width="5%">:</td>
                        <td width="*"><?= $m_jual[0]['nama']; ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Issued by</td>
                        <td width="5%">:</td>
                        <td width="*"><?= $m_jual[0]['issuedby']; ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Keterangan</td>
                        <td width="5%">:</td>
                        <td width="*"></td>
                    </tr>
                </table>
            </td>
            <td colspan="4">
                <table border="0" class="main_table">
                    <tr>
                        <td width="25%">Total</td>
                        <td width="5%">:</td>
                        <td width="*" style='border-top:1px solid black;'><?= number_format($m_jual[0]['total'], 0, '', '.'); ?>,00</td>
                    </tr>
                    <tr>
                        <td width="25%">Discount (%)</td>
                        <td width="5%">:</td>
                        <td width="*"><?= number_format($m_jual[0]['discp'], 0, '', '.'); ?>,00</td>
                    </tr>
                    <tr>
                        <td width="25%">Discount (Rp)</td>
                        <td width="5%">:</td>
                        <td width="*"><?= number_format($m_jual[0]['discn'], 0, '', '.'); ?>,00</td>
                    </tr>
                    <tr>
                        <td width="25%">Grand Total</td>
                        <td width="5%">:</td>
                        <td width="*" style='border-top:1px solid black;'><?= number_format($m_jual[0]['grandtotal'], 0, '', '.'); ?>,00</td>
                    </tr>
                </table>
            </td>
        </tr>
        </tfoot>
    </table>
    <table border="0" class="main_table">
        <tr>
            <td>
                <table class="main_table">
                    <tr>
                        <td>DITERIMA,</td>
                    </tr>
                    <tr>
                        <td><br><br><br><br></td>
                    </tr>
                    <tr>
                        <td>(.............................)</td>
                    </tr>
                    <tr>
                        <td>Nama & Stempel</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="main_table">
                    <tr>
                        <td>DIKIRIM,</td>
                    </tr>
                    <tr>
                        <td><br><br><br><br></td>
                    </tr>
                    <tr>
                        <td>(.............................)</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="main_table">
                    <tr>
                        <td>DIPERIKSA,</td>
                    </tr>
                    <tr>
                        <td><br><br><br><br></td>
                    </tr>
                    <tr>
                        <td>(.............................)</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
}