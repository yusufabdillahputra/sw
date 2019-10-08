$(document).ready(function () {
    'use strict'

    var component_location = 'app/transaksi/penjualan';
    var editIndex = undefined;
    var vno = 1;
    var dg_penjualan = $('#dg_penjualan');

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
                id: 'btn_insert_dg',
                text: 'Insert Detail',
                disabled: true,
                iconCls: 'icon-add',
                plain: true,
                handler: function () {
                    append();
                }
            },
            {
                id: 'btn_delete_dg',
                text: 'Delete Detail',
                disabled: true,
                iconCls: 'icon-remove',
                plain: true,
                handler: function () {
                    removeit();
                }
            },
            {
                id: 'btn_save_dg',
                text: 'Save',
                iconCls: 'icon-save',
                disabled: true,
                plain: true,
                handler: function () {
                    acceptit();
                }
            },
            {
                id: 'btn_reject_dg',
                text: 'Reject',
                iconCls: 'icon-undo',
                disabled: true,
                plain: true,
                handler: function () {
                    reject();
                }
            },
            {
                id: 'btn_search_dg',
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
                                    'tipe_harga': $('#dt_kode_tipe').val(),
                                    'id_barang': value.barang
                                },
                                success: function (parsing_data) {
                                    var data = JSON.parse(parsing_data);
                                    var dg = $('#dg_penjualan');
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
                    $('#dg_penjualan').datagrid('selectRow', index)
                        .datagrid('beginEdit', index);
                    var ed = $('#dg_penjualan').datagrid('getEditor', {
                        index: index,
                        field: field
                    });
                    if (ed) {
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndex = index;
                } else {
                    setTimeout(function () {
                        $('#dg_penjualan').datagrid('selectRow', editIndex);
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
            var dg_tbl = $('#dg_penjualan');
            var editors = dg_tbl.datagrid('getEditors', rowIndex);
            var jumlah_barang = $(editors[0].target); // jumlah
            var harga_beli = $(editors[4].target); // harga jual
            var harga_dasar = $(editors[5].target); // harga jual
            var harga_jual = $(editors[6].target); // harga jual

            var diskon_persen = $(editors[7].target); // diskon persen
            var diskon_rupiah = $(editors[8].target); // diskon rupiah

            var sub_total = $(editors[9].target); // subtotal
            var profit = $(editors[13].target); // profit
            
            jumlah_barang.numberbox({
                onChange: function (newValue, oldValue) {
                    var jumlah = newValue * harga_jual.numberbox('getValue');
                    sub_total.numberbox('setValue', jumlah);

                    var rumus_profit = jumlah - harga_dasar.numberbox('getValue');
                    profit.numberbox('setValue', rumus_profit);
                }
            })
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
                    var rupiah_input = Number(newValue);
                    var index_jumlah = jumlah_barang.numberbox('getValue');
                    var index_harga_jual = harga_jual.numberbox('getValue');
                    var total_jumlah_harga = index_jumlah * index_harga_jual;
                    var convert_persen = (diskon_persen.numberbox('getValue') / 100) * total_jumlah_harga;
                    var total = total_jumlah_harga - (rupiah_input + convert_persen);
                    sub_total.numberbox('setValue', total);

                    var index_harga_dasar = harga_dasar.numberbox('getValue');
                    var rumus_profit = total - index_harga_dasar;
                    profit.numberbox('setValue', rumus_profit);
                }
            });
            harga_jual.numberbox({
                onChange: function (newValue, oldValue) {
                    var rupiah_input = Number(newValue);
                    var val_harga_beli = harga_beli.numberbox('getValue');
                    var val_harga_dasar = harga_dasar.numberbox('getValue');
                    if (rupiah_input < val_harga_beli && rupiah_input < val_harga_dasar) {
                        $.messager.alert({
                            title: 'Peringatan',
                            icon: 'info',
                            msg: 'Harga jual lebih kecil dari harga beli dan harga dasar!<br>Cek kembali harga jualnya.'
                        });
                    } else if (rupiah_input < val_harga_beli || rupiah_input < val_harga_dasar) {
                        $.messager.alert({
                            title: 'Peringatan',
                            icon: 'info',
                            msg: 'Harga jual lebih kecil dari harga beli atau harga dasar!<br>Cek kembali harga jualnya.'
                        });
                    }
                }
            });
        },
        onAfterEdit: function (index, row, changes) {
            var data = $('#dg_penjualan').datagrid('getData');
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

            $('#total').numberbox('setValue', sum);
            $('#grandtotal').numberbox('setValue', sum);
            $('#dthpp').val(hpp);
            $('#dtprofit').val(prf);
        }
    });

    /**
     * Kumpulan function yang dipakai dg_penjualan
     *
     * @return void
     */
    function searchBarang() {
        $.ajax({
            url: component_location + '/component/content_faktur/ajax/window/win_pencarian_barang.php',
            method: 'post',
            data: {
                'dt_kode_tipe': $('#dt_kode_tipe').val()
            },
            success: function (parsing_data) {
                $('#wsearch').html(parsing_data);
                $('#wsearch').window('open');
            }
        });
    }

    function endEditing() {
        if (editIndex == undefined) {
            return true
        }
        if ($('#dg_penjualan').datagrid('validateRow', editIndex)) {
            $('#dg_penjualan').datagrid('endEdit', editIndex);
            editIndex = undefined;
            return true;
        } else {
            return false;
        }
    }

    function append() {
        if (endEditing()) {
            $('#dg_penjualan').datagrid('appendRow', {
                dtno: vno++
            });
            editIndex = $('#dg_penjualan').datagrid('getRows').length - 1;
            $('#dg_penjualan').datagrid('selectRow', editIndex)
                .datagrid('beginEdit', editIndex);
        }
    }

    function removeit() {
        if (editIndex == undefined) {
            return
        }
        $('#dg_penjualan').datagrid('cancelEdit', editIndex)
            .datagrid('deleteRow', editIndex);
        editIndex = undefined;
    }

    function acceptit() {
        if (endEditing()) {
            $('#dg_penjualan').datagrid('acceptChanges');
            var data = $('#dg_penjualan').datagrid('getData');
            var rows = data.rows;
            var id_customer = $('#dtcustomer').combobox('getValue');

            $('#formid').form('submit', {
                url: component_location + '/crud/create/save_hdr_penjualan.php',
                onSubmit: function () {
                    //return console.log(rows);
                    return validasiSubmit(rows, id_customer);
                },
                success: function (data) {
                    $.ajax({
                        async: false,
                        global: false,
                        dataType: 'html',
                        method: 'post',
                        url: component_location + '/crud/create/save_dtl_penjualan.php',
                        data: {
                            'params': rows,
                            'no_faktur': $('#no_faktur').textbox('getValue'),
                            'gudang': $('#dtgudang').combobox('getValue')
                        },
                        success: function (data) {
                            $('#win_insert').window('close');
                        }
                    });
                }
            });
        }
    }
    
    function validasiSubmit(rows, id_customer) {
        var cek_barang = cekIdBarang(rows);
        var cek_harga_jual = validasiHargaJual(rows, id_customer);

        if (cek_barang == false || cek_harga_jual == false) {
            return false;
        } if (cek_barang == true && cek_harga_jual == true) {
            /**
             * todo : kalau sudah semua tolong di true kan
             */
            return false;
        }
    }
    
    function validasiHargaJual(rows, id_customer) {
        var jumlah = [];
        var harga_dasar = [];
        var subtotal = [];
        var nama_barang = [];
        rows.forEach(function (item, index) {
            jumlah.push(Number(item.jumlah));
            harga_dasar.push(Number(item.harga_dasar));
            subtotal.push(Number(item.subtotal));
            nama_barang.push(item.productname);
        });

        $.ajax({
            method: 'post',
            url: component_location + '/crud/validasi/valid_harga_jual.php',
            data: {
                'll_rc2': rows.length,
                'jumlah': jumlah,
                'harga_dasar': harga_dasar,
                'subtotal': subtotal,
                'nama_barang': nama_barang,
                'id_customer' : id_customer
            },
            success: function (parsing_data) {
                var data = JSON.parse(parsing_data);
                if (data.code !== 200) {
                    $.messager.alert({
                        title: 'Peringatan',
                        icon: 'info',
                        msg: data.pesan
                    });
                    return false;
                } else if (data.code == 200) {
                    return true;
                }
            }
        });
    }

    function cekIdBarang(rows) {
        if (rows.length < 1) {
            $.messager.alert({
                title: 'Peringatan',
                icon: 'info',
                msg: 'Detail penjualan barang tidak boleh kosong.'
            });
            return false;
        } else if (rows.length >= 1) {
            /**
             * Ambil id_barang saja untuk filter
             * todo : gunakan filter map array agar dapat memangkas koding
             * @type {Array}
             */
            const result_get_id = [];
            for (const get_id of rows) {
                result_get_id.push(get_id.barang);
            }

            /**
             * Filter data yang sama
             * @type {*[]}
             */
            const not_unique_id = result_get_id.filter(function (value, index, self) {
                return self.indexOf(value) !== index;
            });

            /**
             * Jika data ada yang sama
             * return false menghentikan eksekusi submit
             * return true melanjutkan eksekusi submit
             * DOC : https://www.jeasyui.com/documentation/form.php
             */
            if (typeof not_unique_id !== 'undefined' && not_unique_id.length >= 1) {
                var join_str_nama_barang = [];
                not_unique_id.forEach(function (item) {
                    join_str_nama_barang.push(getNamaBarangIdentik(rows, item));
                });
                var str_nama_barang = join_str_nama_barang.join(', ');
                console.log(str_nama_barang);
                $.messager.alert({
                    title: 'Peringatan',
                    icon: 'info',
                    msg: 'Hapus salah satu baris barang berikut : <b>' + str_nama_barang + '</b>'
                });
                return false;
            } else {
                return true;
            }
        }
    }

    function getNamaBarangIdentik(array, id) {
        var data = [];
        for (var x in array) {
            if (array[x].barang == id) {
                data.push(array[x].productname);
                break;
            }
        }
        return data;
    }

    /**
     * Digunakan apabila hanya ingin mengambil primary key
     *
     * @param array
     * @param id
     * @returns {[]}
     */
    function getBarangIdentik(array, id) {
        var data = [];
        for (var x in array) {
            if (array[x].barang == id) {
                data.push(array[x]);
                break;
            }
        }
        return data;
    }

    function reject() {
        $('#dg_penjualan').datagrid('rejectChanges');
        editIndex = undefined;
    }

    function getChanges() {
        var rows = $('#dg_penjualan').datagrid('getChanges');
        alert(rows.length + ' rows are changed!');
    }

});