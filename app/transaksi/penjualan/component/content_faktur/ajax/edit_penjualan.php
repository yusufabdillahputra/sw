<div id="panel_edit_penjualan" title="Deskripsi Penjualan" style="width: 100%; padding: 8px 8px 8px 8px; overflow: hidden">
    <form id="form_edit" novalidate method="post">
        <input id="e_dt_kode_tipe" name="kode_tipe" type="hidden">
        <input id="e_dthpp" name="hpp" type="hidden">
        <input id="e_dtprofit" name="profit" type="hidden">
        <table style="width: 100%">
            <tr style="margin-bottom:10px">
                <td style="width: 50%">
                    <input name="no_faktur" id="e_no_faktur" readonly style="width:100% ; height: 24px">
                </td>
                <td style="width: 50%">
                    <input name="tgl_jth_tempo" id="e_dtjth_tempo" readonly style="width:100% ; height: 24px">
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr style="margin-bottom:10px">
                <td style="width: 50%">
                    <input id="e_dtgudang" name="gudang" style="width:100% ; height: 24px">
                </td>
                <td style="width: 50%">
                    <input id="e_total" name="total" readonly style="width:100% ; height: 24px">
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr style="margin-bottom:10px">
                <td style="width: 50%">
                    <input id="e_dtcustomer" name="customer" style="width:100% ; height: 24px">
                </td>
                <td style="width: 50%">
                    <input id="e_diskonpersen" name="diskonpersen" style="width:100% ; height: 24px">
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr style="margin-bottom:10px">
                <td style="width: 25%">
                    <input id="e_dttanggal" name="tanggal" style="width:100% ; height: 24px">
                </td>
                <td style="width: 25%">
                    <input id="e_dtmobil" name="mobil" style="width:100% ; height: 24px">
                </td>
                <td style="width: 50%">
                    <input id="e_diskonrp" name="diskonrp" style="width:100% ; height: 24px">
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr style="margin-bottom:10px">
                <td style="width: 50%">
                    <input id="e_salesman" name="salesman" style="width:100% ; height: 24px">
                </td>
                <td style="width: 50%">
                    <input id="e_grandtotal" name="grandtotal" readonly style="width:100% ; height: 24px">
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr style="margin-bottom:10px">
                <td style="width: 50%">
                    <label style="margin-right: 100px">Status</label>
                    <input id="e_status1" name="status">&nbsp;&nbsp;&nbsp;
                    <input id="e_status2" name="status">
                </td>
                <td style="width: 50%">
                    <input id="e_keterangan" name="keterangan" style="width:100% ; height: 24px">
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr style="margin-bottom:10px">
                <td style="width: 50%">
                    <input id="e_dttipe" name="tipe_harga" readonly style="width:100% ; height: 24px">
                </td>
                <td style="width: 50%">

                </td>
            </tr>
        </table>
    </form>
</div>
<table id="e_dg_penjualan" style="height: 800px;"></table>

<div id="e_wsearch" title="Search Barang" style="width:900px;height:500px;padding:10px;"></div>
<?php
$script_path = 'app/transaksi/penjualan/script/content_faktur/ajax/edit_penjualan/';
?>
<script type="text/javascript" src="<?= $script_path; ?>form.js"></script>
<script type="text/javascript" src="<?= $script_path; ?>window.js"></script>
<script type="text/javascript" src="<?= $script_path; ?>edatagrid.js"></script>