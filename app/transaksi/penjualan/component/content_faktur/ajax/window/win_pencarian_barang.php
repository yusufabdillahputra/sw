<?php
$script_path = 'app/transaksi/penjualan/script/content_faktur/ajax/window/';
?>
<input id="dt_tipe_harga" type="hidden" value="<?= htmlspecialchars($_POST['dt_kode_tipe']) ?>">
<div style="align:center; margin-bottom:20px">
    <table>
        <tr>
            <td>
                <input id="tb_kata_pencarian" type="text" name="kata_pencarian" style="width:300px">
            </td>
            <td>
                <button id="bt_submit" class="easyui-linkbutton" style="width:80px" type="submit">Submit</button>
            </td>
        </tr>
    </table>
</div>
<div id="AJAX_dg_cari_barang">
    <table idField="id_barang" id="dg_cari_barang" style="width:auto;height:auto">
        <thead>
        <tr>
            <th data-options="field:'id_barang',width:80">Kode</th>
            <th data-options="field:'nama_barang',width:200">Nama Barang</th>
            <th data-options="field:'harga_beli',width:80,align:'right'">Harga Beli</th>
            <th data-options="field:'harga_dasar',width:80,align:'right'">Harga Dasar</th>
            <th data-options="field:'harga_jual',width:220">Harga Jual</th>
            <th data-options="field:'stok_update',width:60,align:'center'">Jumlah</th>
            <th data-options="field:'nama_satuan',width:60,align:'center'">Satuan</th>
            <th data-options="field:'pilih', checkbox:true">Pilih</th>
        </tr>
        </thead>
    </table>
</div>

<script type="text/javascript" src="<?= $script_path; ?>win_pencarian_barang.js"></script>