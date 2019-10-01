$(document).ready(function () {
    'use strict'

    var component_location = 'app/transaksi/penjualan';

    var json_data = function () {
        var tmp = null;
        $.ajax({
            async: false,
            global: false,
            dataType: 'html',
            url: component_location+'/crud/read/get_cari_barang.php',
            method: 'post',
            data: {
                'tipe_harga': $('#dt_tipe_harga').val()
            },
            success: function (parsing_data) {
                tmp = JSON.parse(parsing_data)
            }
        });
        return tmp;
    }();

    $('#dg_cari_barang').datagrid({
        data : json_data,
        onSelect: function (rowIndex, rowData) {
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
        },
        onUnselect: function (rowIndex, rowData) {
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
    });

    $('#tb_kata_pencarian').textbox({
        label: 'Nama Barang',
        required: false,
        labelWidth: '100px',
    });

    $('#bt_submit').on('click', function () {
        var kata_pencarian = $('#tb_kata_pencarian').val();
        var row_in_penjualan = $('#dg_penjualan').datagrid('getRows');
        $.ajax({
            url: component_location+'/component/content_faktur/ajax/window/ajax_pencarian_barang.php',
            method: 'post',
            data: {
                'kata_pencarian': kata_pencarian,
                'row_in_select': getJustID(row_in_penjualan),
                'tipe_harga': $('#dt_tipe_harga').val()
            },
            success: function (parsing_data) {
                $('#AJAX_dg_cari_barang').html(parsing_data);
            }
        });
    });

    function getJustID(array) {
        var data = [];
        for (var x in array) {
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
            for (var x in data) {
                if (data[x].barang == id) {
                    return x;
                }
            }
            getDGPenjualanRowIndex(data, id);
        }
    }

});