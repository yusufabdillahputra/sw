<div id="panel_form_penjualan" title="Deskripsi Penjualan" style="width: 100%; padding: 8px 8px 8px 8px; overflow: hidden">
    <table style="width: 100%">
        <tr style="margin-bottom:10px">
            <td style="width: 50%">
                <input name="no_faktur" id="no_faktur" readonly style="width:100% ; height: 24px">
            </td>
            <td style="width: 50%">
                <input name="tgl_jth_tempo" id="dtjth_tempo" readonly style="width:100% ; height: 24px">
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr style="margin-bottom:10px">
            <td style="width: 50%">
                <input id="dtgudang" name="gudang" style="width:100% ; height: 24px">
            </td>
            <td style="width: 50%">
                <input id="total" name="total" readonly style="width:100% ; height: 24px">
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr style="margin-bottom:10px">
            <td style="width: 50%">
                <input id="dtcustomer" name="customer" style="width:100% ; height: 24px">
            </td>
            <td style="width: 50%">
                <input id="diskonpersen" name="diskonpersen" style="width:100% ; height: 24px">
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr style="margin-bottom:10px">
            <td style="width: 25%">
                <input id="dttanggal" name="tanggal" style="width:100% ; height: 24px">
            </td>
            <td style="width: 25%">
                <input id="dtmobil" name="mobil" style="width:100% ; height: 24px">
            </td>
            <td style="width: 50%">
                <input id="diskonrp" name="diskonrp" style="width:100% ; height: 24px">
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr style="margin-bottom:10px">
            <td style="width: 50%">
                <input id="salesman" name="salesman" style="width:100% ; height: 24px">
            </td>
            <td style="width: 50%">
                <input id="grandtotal" name="grandtotal" readonly style="width:100% ; height: 24px">
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr style="margin-bottom:10px">
            <td style="width: 50%">
                <label style="margin-right: 100px">Status</label>
                <input id="status1" name="status">&nbsp;&nbsp;&nbsp;
                <input id="status2" name="status">
            </td>
            <td style="width: 50%">
                <input id="keterangan" name="keterangan" style="width:100% ; height: 24px">
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr style="margin-bottom:10px">
            <td style="width: 50%">
                <input id="dttipe" name="tipe_harga" readonly style="width:100% ; height: 24px">
            </td>
            <td style="width: 50%">

            </td>
        </tr>
    </table>
</div>
<table id="dg_penjualan" style="height: 800px;"></table>

<input id="dt_kode_tipe" name="kode_tipe" type="hidden">
<input id="dthpp" name="hpp" type="hidden">
<input id="dtprofit" name="profit" type="hidden">
<div id="wsearch" title="Search Barang" style="width:900px;height:500px;padding:10px;"></div>
<?php
$script_path = 'app/transaksi/penjualan/script/content_faktur/ajax/form_penjualan/';
?>
<script type="text/javascript" src="<?= $script_path; ?>form.js"></script>
<script type="text/javascript" src="<?= $script_path; ?>window.js"></script>
<script type="text/javascript" src="<?= $script_path; ?>edatagrid.js"></script>