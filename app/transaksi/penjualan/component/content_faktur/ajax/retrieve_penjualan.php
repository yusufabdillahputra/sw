<?php
$script_path = 'app/transaksi/penjualan/script/content_faktur/ajax'
?>
<form id="form_retrieve" method="post">
    <center style="margin-top: 10px">
        <div style="margin-bottom: 10px">
            <input id="cb_gudang" label="Gudang" name="gudang" labelPosition="left">
        </div>
        <div style="margin-bottom: 10px">
            <input id="db_tgl_mulai" label="Tanggal" name="tgl_mulai" labelPosition="left">
        </div style="margin-bottom: 10px">
        <div style="margin-bottom: 10px">
            <input id="db_tgl_akhir" label="S/D" name="tgl_akhir" labelPosition="left">
        </div>
        <div>
            <a id="btn_submit" href="javascript:void(0)">Ok</a>
            <a id="btn_cancel" href="javascript:void(0)">Cancel</a>
        </div>
    </center>
</form>
<script type="text/javascript" src="<?= $script_path; ?>/retrieve_penjualan.js"></script>