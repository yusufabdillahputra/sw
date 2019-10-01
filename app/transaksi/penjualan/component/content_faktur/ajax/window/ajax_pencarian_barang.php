<?php
if (isset($_POST['kata_pencarian'])) {
    $kata_pencarian = htmlspecialchars($_POST['kata_pencarian']);
    $tipe_harga = htmlspecialchars($_POST['tipe_harga']);
    $conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");
    $sql = "SELECT barang.*, satuan.*, STRING(barang.percolly, ' ', satuan.nama) as spesifikasi, (select nama from satuan where id = barang_gdg.satuan) as satuan_barang,
            (select harga_beli from barang_sat where id = barang.ID and satuan = barang_gdg.satuan) as sat_harga_beli,
            (select harga_dasar from barang_sat where id = barang.ID and satuan = barang_gdg.satuan) as sat_harga_dasar,
            (select harga from barang_harga where kode_tipe = '$tipe_harga' and barang = barang.ID and satuan = barang_gdg.satuan) as set_harga_jual
            FROM barang, satuan, barang_gdg where barang.satuan_id=satuan.id and barang.ID = barang_gdg.barang AND barang.NAMA LIKE '%$kata_pencarian%'";
    $query = sasql_query($conn, $sql);
    $result = array();
    while ($row = sasql_fetch_array($query)) {
        array_push($result, [
            'id_barang' => $row['ID'],
            'nama_barang' => $row['NAMA'],
            'nama_satuan' => $row['nama'],
            'harga_beli' => $row['sat_harga_beli'],
            'harga_dasar' => $row['sat_harga_dasar'],
            'harga_jual' => $row['set_harga_jual'],
            'spesifikasi' => $row['spesifikasi'],
            'satuan_barang' => $row['satuan_barang']
        ]);
    }
    $parsing_data = json_encode($result);
    ?>
    <table id="dg_cari_barang" style="width:auto;height:auto">
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
    <script>
        $(document).ready(function() {
            $('#dg_cari_barang').datagrid({
                idField: "id_barang",
                rownumbers: true,
                singleSelect: false,
                data: <?= $parsing_data; ?>,
                method: 'get',

                /**
                 * Setelah data success di load maka akan di cek data mana yang sebelumnya telah
                 * di select
                 */
                onLoadSuccess: function() {
                    <?php
                    if (isset($_POST['row_in_select'])) {
                    foreach ($_POST['row_in_select'] as $key_array => $data) {
                    ?>
                    $('#dg_cari_barang').datagrid('selectRecord', <?= $data; ?>);
                    <?php
                    }
                    }
                    ?>
                },

                /**
                 * Kenapa memakai event onClickRow
                 * Dikarenakan apabila event onLoadSuccess menyatakan ada record yang di select
                 * maka data akan otomatis ditambahkan (append) lagi apabila menggunakan onSelect
                 * dikarenakan itu menggunakan event onClickRow
                 * Dimana row yang di select akan di deteksi menggunakan fungsi detectSelection()
                 */
                onClickRow: function(rowIndex, rowData) {
                    var cek_select = detectSelection(rowData.id_barang);
                    if (cek_select == false) {
                        var dg = $('#dg_penjualan');
                        var rows = dg.datagrid('getRows');
                        /**
                         * Logic penghapusan baris
                         */
                        if (getDGPenjualanRowIndex(rows, rowData.id_barang) !== null) {
                            dg.datagrid('deleteRow', getDGPenjualanRowIndex(rows, rowData.id_barang));
                        } else if (getDGPenjualanRowIndex(rows, rowData.id_barang) == null) {
                            dg.datagrid('deleteRow', getDGPenjualanRowIndex(rows, 0));
                        }
                        /**
                         * Reset semua data bertujuan untuk mengembalikan rownumber (index)
                         * menjadi increment yang sempurna 1+n
                         */
                        var data = dg.datagrid('getData').rows;
                        dg.datagrid('loadData', data);
                    }
                    if (cek_select == true) {
                        /**
                         * Set data yang akan di parsing ke datagrid
                         * Penambahan data JSON dapat di set di file cari_barang.php
                         */
                        $('#dg_penjualan').datagrid('appendRow', {
                            barang: rowData.id_barang,
                            productname: rowData.nama_barang,
                            satuan: rowData.satuan_barang,
                            harga_beli: rowData.harga_beli,
                            harga_dasar: rowData.harga_dasar,
                            harga_jual: rowData.harga_jual,
                            spesifikasi: rowData.spesifikasi
                        });
                    }
                }
            });

            /**
             *
             * @param {*} data : berasal dari dg_penjualan , todo : sesuaian dengan nama fieldnya
             * @param {*} id
             */
            function getDGPenjualanRowIndex(data, id) {
                //console.log(data);
                if (id == 0) {
                    return null;
                } else {
                    for (var x in data) {
                        if (data[x].barang == id) {
                            return x;
                        }
                    }
                    getDGPenjualanRowIndex(data, id);
                }
            }

            function getJustID(array) {
                var data = [];
                for (var x in array) {
                    data.push(array[x].barang);
                }
                return data;
            }

            function detectSelection(id) {
                var row_in_select = $('#dg_cari_barang').datagrid('getSelections');
                for (var x in row_in_select) {
                    if (row_in_select[x].id_barang == id) {
                        return true;
                    }
                }
                return false;
            }
        });
    </script>
    <?php
}
