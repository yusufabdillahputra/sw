$(document).ready(function() {
    'use strict'

    var component_location = 'app/transaksi/penjualan';

    $('#cb_gudang').combobox({
        width: 300,
        required: true,
        url: component_location+'/crud/read/get_gudang.php',
        valueField: 'id',
        textField: 'nama_gudang'
    });

    $('#db_tgl_mulai').datebox({
        width: 300,
        required: true,
        formatter: function(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
        },
        parser: function(s) {
            if (!s) return new Date();
            var ss = s.split('/');
            var d = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var y = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(y, m - 1, d);
            } else {
                return new Date();
            }
        }
    });

    $('#db_tgl_akhir').datebox({
        width: 300,
        required: true,
        formatter: function(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
        },
        parser: function(s) {
            if (!s) return new Date();
            var ss = s.split('/');
            var d = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var y = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(y, m - 1, d);
            } else {
                return new Date();
            }
        }
    });

    $('#form_retrieve').form({
        url: component_location+'/crud/read/get_faktur.php',
        onSubmit: function() {
            return $(this).form('enableValidation').form('validate');
        },
        success: function(parsing_data) {
            var parse_data = JSON.parse(parsing_data);
            var dg = $('#dg_menu_faktur');
            dg.datagrid({
                data: parse_data,
                pagination: true,
                rownumbers: false,
                fitColumns: true,
                singleSelect: true,
                columns: [
                    [{
                        field: 'modifydate',
                        title: '<b>Tgl Faktur</b>',
                        align: 'center',
                        width: 100,
                        styler: function(value, rowData, rowIndex) {
                            var color = rowData.color_modifydate;
                            var background = rowData.background;
                            return 'color:' + color + ';';
                        }
                    },
                        {
                            field: 'no_faktur',
                            title: '<b>No Faktur</b>',
                            align: 'center',
                            width: 100,
                            styler: function(value, rowData, rowIndex) {
                                var color = rowData.color_no_faktur;
                                var background = rowData.background;
                                return 'color:' + color + ';';
                            }
                        }
                    ]
                ],
                onLoadSuccess: function() {
                    dg.datagrid('enableFilter');
                },
                onDblClickRow : function(rowIndex,rowData) {
                    $.ajax({
                        url: component_location+'/crud/read/get_data_edit.php',
                        method: 'post',
                        data: {
                            'dtno_faktur' : rowData.no_faktur
                        },
                        success: function(parsing_data){
                            const data = JSON.parse(parsing_data);
                            let dg_penjualan = $('#e_dg_penjualan');
                            //console.log(data);
                            /**
                             * Set Header
                             */
                            $('#e_no_faktur').textbox('setValue', data.header.no_faktur);
                            $('#e_dtjth_tempo').textbox('setValue', data.header.tgl_jthtempo);
                            $('#e_dtgudang').combobox('setValue', data.header.nama_gudang);
                            $('#e_total').numberbox('setValue', data.header.total);
                            $('#e_dtcustomer').combobox('setValue', data.header.nama_customer);
                            $('#e_diskonpersen').numberbox('setValue', data.header.discountp);
                            $('#e_diskonrp').numberbox('setValue', data.header.discountn);
                            $('#e_dtmobil').combobox('setValue', data.header.nama_mobil);
                            $('#e_dttanggal').datebox('setValue', data.header.tanggal);
                            $('#e_salesman').combobox('setValue', data.header.salesman);
                            $('#e_grandtotal').numberbox('setValue', data.header.grandtotal);
                            if (data.header.status == 'T') {
                                $('#e_status1').radiobutton('setValue', data.header.status);
                            } else if (data.header.status == 'K') {
                                $('#e_status1').radiobutton('setValue', data.header.status);
                            }
                            $('#e_keterangan').textbox('setValue', data.header.keterangan);
                            $('#e_dttipe').textbox('setValue', data.header.tipe_harga);

                            /**
                             * Set Body
                             */
                            dg_penjualan.edatagrid('loadData', data.body);
                            if (data.body.length > 0) {
                                $('#e_btn_insert_dg').linkbutton({
                                    disabled: false
                                });
                                $('#e_btn_delete_dg').linkbutton({
                                    disabled: false
                                });
                                $('#e_btn_save_dg').linkbutton({
                                    disabled: false
                                });
                                $('#e_btn_reject_dg').linkbutton({
                                    disabled: false
                                });
                                $('#e_btn_search_dg').linkbutton({
                                    disabled: false
                                });
                            }

                            $('#win_edit').window('open');
                        }
                    });
                },
                onClickRow: function(rowIndex, rowData) {
                    $.ajax({
                        url: component_location+'/component/content_faktur/ajax/faktur_penjualan.php',
                        method: 'post',
                        data: {
                            'no_faktur_db': rowData.no_faktur_db,
                            'no_faktur': rowData.no_faktur
                        },
                        success: function(parsing_data) {
                            $('#AJAX_V_Faktur').html(parsing_data);
                        }
                    });
                }
            });

            $('#win_retrieve').window('close');
        }
    });
    
    $('#btn_submit').linkbutton({
        onClick: function() {
            $('#form_retrieve').form('submit');
        }
    });
    $('#btn_cancel').linkbutton({
        onClick: function() {
            $('#win_retrieve').window('close');
        }
    });
});