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
                fitColumns: true,
                rownumbers: true,
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