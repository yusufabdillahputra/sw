<div style="padding:7px;">
    <a id="btn_insert" href="javascript:void(0)">Insert</a>
    <a id="btn_edit" href="javascript:void(0)">Edit</a>
    <a id="btn_delete" href="javascript:void(0)">Delete</a>
    <a id="btn_retrieve" href="javascript:void(0)">Retrieve</a>
    <a id="btn_print" href="javascript:void(0)">Print</a>
</div>

<div id="win_insert" title="Transaksi Penjualan">
    <div id="panel_insert"></div>
</div>

<div id="win_retrieve" title="Retrieve Period">
    <div id="panel_retrieve"></div>
</div>

<div style='padding:10px;border:1px dotted black;width:90%;margin-left:8px;'>
    <div id="AJAX_V_Faktur"></div>
</div>

<?php $script_path = 'app/transaksi/penjualan/script/content_faktur'; ?>
<script type="text/javascript" src="<?= $script_path; ?>/index.js"></script>