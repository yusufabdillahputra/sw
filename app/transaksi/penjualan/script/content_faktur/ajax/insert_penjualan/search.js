$(document).ready(function () {
    'use strict'

    let component_location = 'app/transaksi/penjualan';

    let dg = $('#dg_penjualan');

    console.log($('#dtcustomer').combobox('getValue'));
    console.log($('#dtgudang').combobox('getValue'));

    $('#dg_cari_barang').datagrid({
        onBeforeLoad: function() {
            $.ajax({
                async: false,
                global: false,
                dataType: 'html',
                url: component_location+'/crud/read/get_cari_barang.php',
                method: 'post',
                data: {
                    'cust_id': $('#dtcustomer').combobox('getValue'),
                    'id_gudang': $('#dtgudang').combobox('getValue'),

                },
                success: function (parsing_data) {
                    let json_data = JSON.parse(parsing_data);
                    $('#dg_cari_barang').datagrid('loadData',json_data);
                }
            });
        },
        onSelect: function (rowIndex, rowData) {
            /**
             * Set data yang akan di parsing ke datagrid
             * Penambahan data JSON dapat di set di file cari_barang.php
             */
            dg.datagrid('appendRow', {
                barang: rowData.id_barang,
                productname: rowData.nama_barang,
                satuan: rowData.satuan_barang,
                harga_beli: rowData.harga_beli,
                harga_dasar: rowData.harga_dasar,
                harga_jual: rowData.harga_jual,
                spesifikasi: rowData.spesifikasi
            });
        },
        onUnselect: function (rowIndex, rowData) {
            let rows = dg.datagrid('getRows');
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
            let data = dg.datagrid('getData').rows;
            dg.datagrid('loadData', data);
        }
    });
    $('#tb_kata_pencarian').textbox({
        label: 'Nama Barang',
        required: false,
        labelWidth: '100px',
    });
    $('#bt_submit').on('click', function () {
        let kata_pencarian = $('#tb_kata_pencarian').val();
        let row_in_penjualan = $('#dg_penjualan').datagrid('getRows');
        $.ajax({
            url: component_location+'/component/content_faktur/ajax/window/insert/ajax_pencarian_barang.php',
            method: 'post',
            data: {
                'kata_pencarian': kata_pencarian,
                'row_in_select': getJustID(row_in_penjualan),
                'cust_id': $('#dtcustomer').combobox('getValue'),
                'id_gudang': $('#dtgudang').combobox('getValue')
            },
            success: function (parsing_data) {
                $('#AJAX_dg_cari_barang').html(parsing_data);
            }
        });
    });

    function getJustID(array) {
        let data = [];
        for (let x in array) {
            data.push(array[x].barang);
        }
        return data;
    }

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
            for (let x in data) {
                if (data[x].barang == id) {
                    return x;
                }
            }
            getDGPenjualanRowIndex(data, id);
        }
    }

});