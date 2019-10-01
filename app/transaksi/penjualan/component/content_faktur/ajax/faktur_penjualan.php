<?php
if (isset($_POST['no_faktur_db'])) {

    $no_faktur_db = htmlspecialchars($_POST['no_faktur_db']);
    $no_faktur = htmlspecialchars($_POST['no_faktur']);

    $conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");

    $customer_sql = "SELECT * FROM customer,master_jual,KOTA where customer.kota=KOTA.ID and master_jual.no_faktur='$no_faktur_db'";
    $customer_query = sasql_query($conn, $customer_sql);
    $customer = array();
    while ($row = sasql_fetch_array($customer_query)) {
        array_push($customer, [
            'nama' => $row['nama'],
            'kota' => $row['NAMA'],
        ]);
    }

    $j_jual_sql = "SELECT * FROM j_jual,master_jual,satuan,barang where j_jual.barang_id=barang.ID and master_jual.no_faktur=j_jual.no_faktur and j_jual.satuan=satuan.id and master_jual.no_faktur='$no_faktur_db'";
    $j_jual_query = sasql_query($conn, $j_jual_sql);
    $j_jual = array();
    while ($row = sasql_fetch_array($j_jual_query)) {

        $jatuh_tempo=$row['jth_tempo']; {
            $var = $jatuh_tempo;
            $date = str_replace('-', '/', $var);}

        array_push($j_jual, [
            'jumlah' => $row['jumlah'],
            'jth_tempo' => $row['jth_tempo'],
            'nama' => $row['nama'],
            'NAMA' => $row['NAMA'],
            'disctp' => $row['discountp'],
            'disctn' => $row['discountn'],
            'harga' => $row['harga'],
            'colly' => $row['colly'],
            'ket' => $row['ket'],
            'subtot' => $row['harga'] * $row['jumlah']
        ]);
    }

    $m_jual_sql = "SELECT * FROM master_jual,pegawai where master_jual.sales_id=pegawai.id and master_jual.no_faktur='$no_faktur_db'";
    $m_jual_query = sasql_query($conn, $m_jual_sql);
    $m_jual = array();
    while ($row = sasql_fetch_array($m_jual_query)) {
        array_push($m_jual, [
            'total' => $row['total'],
            'nama' => $row['nama'],
            'issuedby' => $row['issuedby'],
            'discp' => $row['discountp'],
            'discn' => $row['discountn'],
            'grandtotal' => $row['total'] + $row['discountp'] + $row['discountn']
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
                        <td width="*"></td>
                    </tr>
                </table>
            </td>
            <td width="33%">
                <table class="main_table">
                    <tr>
                        <td width="30%">Tgl jth. tempo</td>
                        <td width="5%">:</td>
                        <td width="*">	<?php echo date('d F Y', strtotime($date));?></td>
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
            <th width="10%">Barang</th>
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

