<form id="formid" method="post" novalidate>
    <input id="dt_kode_tipe" name="kode_tipe" type="hidden">
    <div style="margin-bottom:5px;padding: 5px 5px;">
        <input class="easyui-textbox" name="no_faktur" id="no_faktur" readonly style="width:40%"
               data-options="label:'No Faktur',required:true">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="easyui-textbox" name="tgl_jth_tempo" readonly="readonly" id="dtjth_tempo" style="width:40%"
               data-options="label:'Tgl Jth Tempo'">
    </div>
    <div style="margin-bottom:5px;padding: 5px 5px;">
        <input id="dtgudang" class="easyui-combobox" label="Gudang" name="gudang" style="width:40%">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="easyui-numberbox" name="total" id="total" readonly="readonly" style="width:40%"
               data-options="label:'Total',min:0,precision:2">
    </div>
    <div style="margin-bottom:5px;padding: 5px 5px;">

        <input id="dtcustomer" label="Customer" name="customer" style="width:40%">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="easyui-numberbox" name="diskonpersen" id="diskonpersen" style="width:40%">
    </div>
    <div style="margin-bottom:5px;padding: 5px 5px;">
        <input class="easyui-datebox" name="tanggal" id="dttanggal" style="width:20%">
        &nbsp;&nbsp;
        <input id="dtmobil" class="easyui-combobox" label="Mobil" name="mobil" style="width:19%">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="easyui-numberbox" name="diskonrp" style="width:40%" id="diskonrp">
    </div>
    <div style="margin-bottom:5px;padding: 5px 5px;">
        <input id="dtmobil" class="easyui-combobox" id="salesman" label="Salesman" name="salesman" style="width:40%">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="easyui-numberbox" name="grandtotal" style="width:40%" id="grandtotal" readonly="readonly"
               data-options="label:'Grand Total',min:0,precision:2">
    </div>
    <div style="margin-bottom:5px;padding: 5px 5px;">
        <label>Status</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <input id="status1" name="status" label="Status">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input id="status2" name="status">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="hidden" name="hpp" id="dthpp" value="">
        <input type="hidden" name="profit" id="dtprofit" value="">
    </div>
    <div style="margin-bottom:5px;padding: 5px 5px;">
        <input id="dttipe" readonly="readonly" class="easyui-textbox" name="tipe_harga" label="Tipe Harga"
               style="width:40%" data-options="valueField:'nama_tipe'">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="easyui-textbox" name="keterangan" id="keterangan" style="width:40%"
               data-options="label:'Keterangan'">
    </div>
</form>
<br>
<!-- Pembaruan yang telah dilakukan-->
<table id="dg_penjualan" style="width:100%;max-width: auto;height:auto;"></table>

<div id="wsearch" title="Search Barang" style="width:900px;height:500px;padding:10px;"></div>

<?php
$script_path = 'app/transaksi/penjualan/script/content_faktur/ajax/form_penjualan/';
?>
<script type="text/javascript" src="<?= $script_path; ?>form.js"></script>
<script type="text/javascript" src="<?= $script_path; ?>window.js"></script>
<script type="text/javascript" src="<?= $script_path; ?>edatagrid.js"></script>