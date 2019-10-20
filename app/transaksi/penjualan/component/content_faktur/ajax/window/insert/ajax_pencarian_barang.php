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

if (isset($_POST['kata_pencarian'])) {
    $kata_pencarian = htmlspecialchars($_POST['kata_pencarian']);
    $cust_id = htmlspecialchars($_POST['cust_id']);
    $id_gudang = htmlspecialchars($_POST['id_gudang']);

    $sql = "declare @tipe_harga TEXT

            select @tipe_harga = kode_tipe from customer where id = '$cust_id'

            select top 120
                brg.ID, 
                brg.NAMA, 
                sat.harga_beli, 
                sat.harga_dasar, 
                hrg.harga as harga_jual,
                gdg.jumlah,
                st.nama,
                STRING(brg.percolly,' ',st.nama) as spesifikasi
            from barang_sat as sat 
            left join barang_gdg as gdg 
                on sat.id = gdg.barang
                and sat.satuan = gdg.satuan
            left join barang as brg
                on brg.id = gdg.barang
            left join satuan as st
                on gdg.satuan = st.id
            left join barang_harga as hrg
                on brg.id = hrg.barang
            where
                gdg.gudang = '$id_gudang'
            and brg.status = '1'
            and hrg.kode_tipe = @tipe_harga
            and brg.NAMA LIKE '%$kata_pencarian%'
            order by
                brg.NAMA asc";
    $fetch = $db->get($sql, false);

    $result = array();
    foreach ($fetch as $row) {
        array_push($result, [
            'id_barang'     => $row['ID'],
            'nama_barang'   => $row['NAMA'],
            'harga_beli'    => $row['harga_beli'],
            'harga_dasar'   => $row['harga_dasar'],
            'harga_jual'    => $row['harga_jual'],
            'jumlah'        => $row['jumlah'],
            'satuan_barang' => $row['nama'],
            'spesifikasi'   => $row['spesifikasi']
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
            <th data-options="field:'jumlah',width:60,align:'center'">Jumlah</th>
            <th data-options="field:'satuan_barang',width:60,align:'center'">Satuan</th>
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
                onLoadSuccess: function(data) {
                    let cek_id = getJustID(data.rows);
                    <?php
                    if (isset($_POST['row_in_select'])) {
                        foreach ($_POST['row_in_select'] as $key_array => $data) {
                            ?>
                            var cek = cek_id.includes('<?= $data ?>');
                            if (cek == true) {
                                $('#dg_cari_barang').datagrid('selectRecord', '<?= $data; ?>');
                            }
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
                    data.push(array[x].id_barang);
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
