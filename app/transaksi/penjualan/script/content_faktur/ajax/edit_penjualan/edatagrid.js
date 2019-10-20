$(document).ready(function () {
    'use strict'

    var component_location = 'app/transaksi/penjualan';
    var editIndex = undefined;
    var vno = 1;
    var dg_penjualan = $('#e_dg_penjualan');

    /**
     * Konfigurasi datagrid dg_penjualan
     */
    dg_penjualan.edatagrid({
        iconCls: 'icon-edit',
        singleSelect: true,
        fit: true,
        fitColumn: true,
        rownumbers: true,
        toolbar: [
            {
                id: 'e_btn_insert_dg',
                text: 'Insert Detail',
                disabled: true,
                iconCls: 'icon-add',
                plain: true,
                handler: function () {
                    append();
                }
            },
            {
                id: 'e_btn_delete_dg',
                text: 'Delete Detail',
                disabled: true,
                iconCls: 'icon-remove',
                plain: true,
                handler: function () {
                    removeit();
                }
            },
            {
                id: 'e_btn_save_dg',
                text: 'Save',
                iconCls: 'icon-save',
                disabled: true,
                plain: true,
                handler: function () {
                    acceptit();
                }
            },
            {
                id: 'e_btn_reject_dg',
                text: 'Reject',
                iconCls: 'icon-undo',
                disabled: true,
                plain: true,
                handler: function () {
                    reject();
                }
            },
            {
                id: 'e_btn_search_dg',
                text: 'Search',
                iconCls: 'icon-search',
                disabled: true,
                plain: true,
                handler: function () {
                    searchBarang();
                }
            },
        ],
        columns: [[
            {
                title: 'Jumlah',
                field: 'jumlah',
                align: 'center',
                halign: 'center',
                width: 50,
                editor: {
                    type: 'numberbox',
                    options: {
                        precision: 2
                    }
                }
            },
                {
                    title: 'Satuan',
                    field: 'satuan',
                    align: 'center',
                    halign: 'center',
                    width: 60,
                    editor: {
                        type: 'textbox',
                        options: {
                            readonly: true
                        }
                    }
                },
                {
                    title: 'Barang',
                    field: 'barang',
                    align: 'center',
                    halign: 'center',
                    width: 200,
                    formatter: function (value, row) {
                        return row.productname;
                    },
                    editor: {
                        type: 'combobox',
                        options: {
                            valueField: 'barang',
                            textField: 'productname',
                            method: 'get',
                            url: component_location + '/crud/read/get_barang.php',
                            required: true,
                            onSelect: function (value) {
                                $.ajax({
                                    url: component_location + '/crud/read/get_data_barang.php',
                                    method: 'post',
                                    data: {
                                        'tipe_harga': $('#e_dt_kode_tipe').val(),
                                        'id_barang': value.barang
                                    },
                                    success: function (parsing_data) {
                                        var data = JSON.parse(parsing_data);
                                        var dg = $('#e_dg_penjualan');
                                        var row = dg.datagrid('getSelected');
                                        var rowIndex = dg.datagrid('getRowIndex', row);
                                        var ed1 = dg.datagrid('getEditor', {
                                            index: rowIndex,
                                            field: 'satuan'
                                        });
                                        var ed2 = dg.datagrid('getEditor', {
                                            index: rowIndex,
                                            field: 'harga_beli'
                                        });
                                        var ed3 = dg.datagrid('getEditor', {
                                            index: rowIndex,
                                            field: 'harga_dasar'
                                        });
                                        var ed4 = dg.datagrid('getEditor', {
                                            index: rowIndex,
                                            field: 'harga_jual'
                                        });
                                        var ed5 = dg.datagrid('getEditor', {
                                            index: rowIndex,
                                            field: 'spesifikasi'
                                        });
                                        var ed6 = dg.datagrid('getEditor', {
                                            index: rowIndex,
                                            field: 'idbarang'
                                        });

                                        if (data.harga_jual == null) {
                                            alert('Harga jual barang = 0 untuk Tipe Harga ' + data.tipe_harga + ' . Anda belum setting harga jual di master barang.');
                                            $(ed1.target).textbox('readonly', true);
                                            $(ed2.target).numberbox('readonly', true);
                                            $(ed3.target).numberbox('readonly', true);
                                            $(ed4.target).numberbox('readonly', false);
                                            $(ed5.target).textbox('readonly', true);
                                            $(ed6.target).textbox('readonly', true);
                                        } else {
                                            $(ed1.target).textbox('setValue', data.satuan_barang);
                                            $(ed2.target).numberbox('setValue', data.harga_beli);
                                            $(ed3.target).numberbox('setValue', data.harga_dasar);
                                            $(ed4.target).numberbox('setValue', data.harga_jual);
                                            $(ed5.target).textbox('setValue', data.spesifikasi);
                                            $(ed6.target).textbox('setValue', data.id_barang);
                                        }
                                    }
                                });
                            }
                        }
                    }
                },
                {
                    title: 'Spesifikasi',
                    field: 'spesifikasi',
                    align: 'center',
                    halign: 'center',
                    width: 120,
                    editor: {
                        type: 'textbox',
                        options: {
                            readonly: true
                        }
                    }
                },
                {
                    title: 'Harga Beli',
                    field: 'harga_beli',
                    align: 'right',
                    halign: 'center',
                    width: 100,
                    editor: {
                        type: 'numberbox',
                        options: {
                            precision: 2,
                            readonly: true
                        }
                    }
                },
                {
                    title: 'Harga Dasar',
                    field: 'harga_dasar',
                    halign: 'center',
                    width: 100,
                    align: 'right',
                    editor: {
                        type: 'numberbox',
                        options: {
                            precision: 2,
                            readonly: true
                        }
                    }
                },
                {
                    title: 'Harga Jual',
                    field: 'harga_jual',
                    halign: 'center',
                    width: 100,
                    align: 'right',
                    editor: {
                        type: 'numberbox',
                        options: {
                            precision: 2
                        }
                    }
                },
                {
                    title: 'Disc %',
                    field: 'discpersen',
                    halign: 'center',
                    width: 100,
                    editor: {
                        type: 'numberbox',
                        options: {
                            precision: 2
                        }
                    }
                },
                {
                    title: 'Disc Rp.',
                    field: 'discrupiah',
                    align: 'right',
                    halign: 'center',
                    width: 100,
                    editor: {
                        type: 'numberbox',
                        options: {
                            precision: 2
                        }
                    }
                },
                {
                    title: 'Sub Total',
                    field: 'subtotal',
                    align: 'right',
                    halign: 'center',
                    width: 150,
                    editor: {
                        type: 'numberbox',
                        options: {
                            precision: 2,
                            readonly: true
                        }
                    }
                },
                {
                    title: 'Colly',
                    field: 'colly',
                    halign: 'center',
                    width: 50,
                    align: 'right',
                    editor: 'textbox'
                },
                {
                    title: 'Ket',
                    field: 'ket',
                    halign: 'center',
                    width: 50,
                    align: 'right',
                    editor: 'textbox'
                },
                {
                    title: 'Ket SO',
                    field: 'ket_so',
                    halign: 'center',
                    width: 100,
                    align: 'right',
                    editor: 'textbox'
                },
                {
                    title: '',
                    field: 'data_profit',
                    width: 5,
                    editor: {
                        type: 'numberbox',
                        options: {
                            precision: 0,
                            readonly: true
                        }
                    }
                },
                {
                    title: '',
                    field: 'idbarang',
                    width: 5,
                    editor: 'textbox'
                }
            ]
        ],
        onClickCell: function (index, field, value) {
            if (editIndex != index) {
                if (endEditing()) {
                    $('#e_dg_penjualan').datagrid('selectRow', index)
                        .datagrid('beginEdit', index);
                    var ed = $('#e_dg_penjualan').datagrid('getEditor', {
                        index: index,
                        field: field
                    });
                    if (ed) {
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndex = index;
                } else {
                    setTimeout(function () {
                        $('#e_dg_penjualan').datagrid('selectRow', editIndex);
                    }, 0);
                }
            }
        },
        onEndEdit: function (index, row, changes) {
            var ed = $(this).datagrid('getEditor', {
                index: index,
                field: 'barang'
            });
            row.productname = $(ed.target).combobox('getText');
        },
        onBeginEdit: function (rowIndex) {
            var dg_tbl = $('#e_dg_penjualan');
            var editors = dg_tbl.datagrid('getEditors', rowIndex);
            var jumlah_barang = $(editors[0].target); // jumlah
            var harga_dasar = $(editors[5].target); // harga jual
            var harga_jual = $(editors[6].target); // harga jual

            var diskon_persen = $(editors[7].target); // diskon persen
            var diskon_rupiah = $(editors[8].target); // diskon rupiah

            var sub_total = $(editors[9].target); // subtotal
            var profit = $(editors[13].target); // profit

            var sum_disk_subtotal = {
                diskon_persen: 0,
                diskon_rupiah: 0
            };

            jumlah_barang.numberbox({
                onChange: function (newValue, oldValue) {
                    var jumlah = newValue * harga_jual.numberbox('getValue');
                    sub_total.numberbox('setValue', jumlah);

                    var rumus_profit = jumlah - harga_dasar.numberbox('getValue');
                    profit.numberbox('setValue', rumus_profit);
                }
            }),
                diskon_persen.numberbox({
                    onChange: function (newValue, oldValue) {
                        var index_jumlah = jumlah_barang.numberbox('getValue');
                        var index_harga_jual = harga_jual.numberbox('getValue');
                        var index_harga_dasar = harga_dasar.numberbox('getValue');
                        var total_jumlah_harga = index_jumlah * index_harga_jual;
                        var jumlah = (newValue / 100) * total_jumlah_harga;
                        var old_sub_total = total_jumlah_harga;
                        var total = old_sub_total - (jumlah + diskon_rupiah.numberbox('getValue'));
                        sub_total.numberbox('setValue', total);

                        var rumus_profit = total - index_harga_dasar;
                        profit.numberbox('setValue', rumus_profit);
                    }
                });
            diskon_rupiah.numberbox({
                onChange: function (newValue, oldValue) {
                    var index_jumlah = jumlah_barang.numberbox('getValue');
                    var index_harga_jual = harga_jual.numberbox('getValue');
                    var index_harga_dasar = harga_dasar.numberbox('getValue');
                    var total_jumlah_harga = index_jumlah * index_harga_jual;
                    var jumlah = total_jumlah_harga - newValue;
                    var old_sub_total = total_jumlah_harga;
                    var convert_persen = (diskon_persen.numberbox('getValue') / 100) * total_jumlah_harga;
                    var total = (jumlah + convert_persen) - old_sub_total;
                    sub_total.numberbox('setValue', total);

                    var rumus_profit = total - index_harga_dasar;
                    profit.numberbox('setValue', rumus_profit);
                }
            });
        },
        onAfterEdit: function (index, row, changes) {
            var data = $('#e_dg_penjualan').datagrid('getData');
            var rows = data.rows;
            var sum = 0;
            var hpp = 0;
            var prf = 0;

            let i;
            for (i = 0; i < rows.length; i++) {
                sum += parseInt(rows[i].subtotal);
            }

            for (i = 0; i < rows.length; i++) {
                hpp += parseInt(rows[i].harga_jual);
            }

            for (i = 0; i < rows.length; i++) {
                prf += parseInt(rows[i].data_profit);
            }

            $('#e_total').numberbox('setValue', sum);
            $('#e_grandtotal').numberbox('setValue', sum);
            $('#e_dthpp').val(hpp);
            $('#e_dtprofit').val(prf);
        }
    });

    /**
     * Kumpulan function yang dipakai dg_penjualan
     *
     * @return void
     */
    function searchBarang() {
        $('#e_wsearch').window('refresh', component_location + '/component/content_faktur/ajax/window/edit/win_pencarian_barang.php');
        $('#e_wsearch').window('open');
    }

    function endEditing() {
        if (editIndex == undefined) {
            return true
        }
        if ($('#e_dg_penjualan').datagrid('validateRow', editIndex)) {
            $('#e_dg_penjualan').datagrid('endEdit', editIndex);
            editIndex = undefined;
            return true;
        } else {
            return false;
        }
    }

    function append() {
        if (endEditing()) {
            $('#e_dg_penjualan').datagrid('appendRow', {
                dtno: vno++
            });
            editIndex = $('#e_dg_penjualan').datagrid('getRows').length - 1;
            $('#e_dg_penjualan').datagrid('selectRow', editIndex)
                .datagrid('beginEdit', editIndex);
        }
    }

    function removeit() {
        if (editIndex == undefined) {
            return
        }
        $('#e_dg_penjualan').datagrid('cancelEdit', editIndex)
            .datagrid('deleteRow', editIndex);
        editIndex = undefined;
    }

    function acceptit() {
        if (endEditing()) {
            $('#e_dg_penjualan').datagrid('acceptChanges');
            var data = $('#e_dg_penjualan').datagrid('getData');
            var rows = data.rows;

            $('#form_edit').form('submit', {
                url: component_location + '/crud/create/save_hdr_penjualan.php',
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (data) {
                    console.log('ini isi data headernya =', data);
                    $.ajax({
                        async:false,
                        global:false,
                        dataType: 'html',
                        method: 'post',
                        url: component_location + '/crud/create/save_dtl_penjualan.php',
                        data: {
                            'params': rows,
                            'no_faktur': $('#e_no_faktur').textbox('getValue'),
                            'gudang': $('#e_dtgudang').combobox('getValue')
                        },
                        success: function (data) {
                            console.log('ini isi datanya =', data);
                        }
                    });
                }
            });
        }
    }

    function reject() {
        $('#e_dg_penjualan').datagrid('rejectChanges');
        editIndex = undefined;
    }

    function getChanges() {
        var rows = $('#e_dg_penjualan').datagrid('getChanges');
        alert(rows.length + ' rows are changed!');
    }

});