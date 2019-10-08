$(document).ready(function () {
    'use strict'

    var component_location = 'app/transaksi/penjualan';
    var panel_form = $('#panel_form_penjualan');
    var numberbox_diskonpersen = $('#diskonpersen');
    var numberbox_diskonrp = $('#diskonrp');

    panel_form.panel({
        fit: false,
        border: true,
        iconCls: '',
        collapsible: true,
        minimizable: false,
        maximizable: false,
        closable: false
    });

    /**
     * Deskripsi Penjualan
     * Row 1
     */
    $('#no_faktur').textbox({
        label: 'No Faktur',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        required: true
    });

    $('#dtjth_tempo').textbox({
        label: 'Tgl Jth Tempo',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
    });

    /**
     * Row 2
     */
    $('#dtgudang').combobox({
        valueField: 'id',
        textField: 'nama',
        label: 'Gudang',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        url: component_location + '/crud/read/get_data_gudang.php'
    });

    $('#total').numberbox({
        label: 'Total',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        min: 0,
        precision: 2
    });

    /**
     * Row 3
     */
    $('#dtcustomer').combobox({
        label: 'Customer',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        required: true,
        valueField: 'id',
        textField: 'nama',
        url: component_location + '/crud/read/get_customer.php',
        onSelect: function (rec) {
            $.ajax({
                type: 'post',
                url: component_location + '/crud/validasi/valid_customer.php',
                data: {
                    'customer_id': rec.id
                },
                success: function (parsing_data) {
                    var data = JSON.parse(parsing_data);
                    if (data.status == true) {
                        $.messager.alert({
                            title: 'Peringatan',
                            icon: 'info',
                            msg: data.message
                        });
                    }
                }
            });


            $('#dttipe').textbox('setValue', rec.nama_tipe);
            $('#dtjth_tempo').textbox('setValue', rec.tgl_jth_tempo);
            $('#dttanggal').datebox('setValue', rec.tgl_transaksi);

            /**
             * Set value dom yang akan digunakan untuk tipe costumer
             */
            $('#dt_kode_tipe').val(rec.kode_tipe);
            /**
             * Set properti dg_penjualan
             */
            $('#btn_insert_dg').linkbutton({
                disabled: false
            });
            $('#btn_delete_dg').linkbutton({
                disabled: false
            });
            $('#btn_save_dg').linkbutton({
                disabled: false
            });
            $('#btn_reject_dg').linkbutton({
                disabled: false
            });
            $('#btn_search_dg').linkbutton({
                disabled: false
            });

            /**
             * Set No Faktur Otomatis
             */

            $.ajax({
                type: 'get',
                url: component_location + '/crud/read/get_data_faktur.php',
                success: function (data) {
                    var vdata = JSON.parse(data);
                    var dt_comp = vdata.comp_id;
                    var dt_blnthn = vdata.blnthn;
                    var dt_faktur = vdata.faktur;

                    var dt_gudang = $('#dtgudang').combobox('getValue');

                    var no_faktur = dt_comp + '/' + dt_faktur + '/' + dt_blnthn + '/' + dt_gudang + '/JB';

                    console.log('ini auto faktur', no_faktur);
                    $('#no_faktur').textbox('setValue', no_faktur);
                }
            });
        }
    });

    numberbox_diskonpersen.numberbox({
        label: 'Discount %',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        min: 0,
        max: 99,
        precision: 2,
        onChange: function (newValue, oldValue) {
            var total = parseInt($('#total').numberbox('getValue'));
            var jumlah = (parseInt(newValue) / 100) * total;
            var parsing_total = total - (jumlah + numberbox_diskonrp.numberbox('getValue'));
            $('#grandtotal').numberbox('setValue', parsing_total);
        }
    });

    /**
     * Row 4
     */
    $('#dttanggal').datebox({
        label: 'Tanggal',
        labelWidth: 100,
        labelPosition: 'before',
        width: 300,
        required: true,
        formatter: function (date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return m + '/' + d + '/' + y;
        },
        parser: function (s) {
            var t = Date.parse(s);
            if (!isNaN(t)) {
                return new Date(t);
            } else {
                return new Date();
            }
        },
        onSelect: function (date_input) {
            /**
             * Contoh : 01/10/2019
             * @type {string}
             */
            var date = new Date();
            var date_sekarang = Date.parse((date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear());
            var tgl_input = Date.parse((date_input.getMonth() + 1) + "/" + date_input.getDate() + "/" + date_input.getFullYear());

            if (tgl_input > date_sekarang) {
                $.ajax({
                    type: 'post',
                    url: component_location + '/crud/validasi/valid_tgl_maju.php',
                    data: {
                        'tgl': (date_input.getMonth() + 1) + "/" + date_input.getDate() + "/" + date_input.getFullYear()
                    },
                    success: function (parsing_data) {
                        var data = JSON.parse(parsing_data);
                        if (data.code == 401) {
                            $.messager.alert({
                                title: 'Peringatan',
                                icon: 'info',
                                msg: data.message
                            });
                            $('#dttanggal').datebox('setValue', null);
                        }
                    }
                });
            } if (tgl_input < date_sekarang) {
                $.ajax({
                    type: 'post',
                    url: component_location + '/crud/validasi/valid_tgl_mundur.php',
                    data: {
                        'tgl': (date_input.getMonth() + 1) + "/" + date_input.getDate() + "/" + date_input.getFullYear()
                    },
                    success: function (parsing_data) {
                        var data = JSON.parse(parsing_data);
                        if (data.code == 401) {
                            $.messager.alert({
                                title: 'Peringatan',
                                icon: 'info',
                                msg: data.message
                            });
                            $('#dttanggal').datebox('setValue', null);
                        }
                    }
                });
            }
        }
    });

    $('#dtmobil').combobox({
        valueField: 'id',
        textField: 'nama',
        label: 'Mobil',
        labelWidth: 60,
        labelPosition: 'before',
        width: 267,
        url: component_location + '/crud/read/get_data_mobil.php'
    });

    numberbox_diskonrp.numberbox({
        label: 'Discount Rp',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        min: 0,
        precision: 2,
        onChange: function (newValue, oldValue) {
            var total = parseInt($('#total').numberbox('getValue'));
            var convert_persen = (parseInt(numberbox_diskonpersen.numberbox('getValue')) / 100) * total;
            var parsing_total = total - (parseInt(newValue) + convert_persen);
            $('#grandtotal').numberbox('setValue', parsing_total);
        }
    });

    /**
     * Row 5
     */
    $('#salesman').combobox({
        label: 'Salesman',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        required: true,
        valueField: 'id',
        textField: 'nama',
        url: component_location + '/crud/read/get_data_sales.php'
    });

    $('#grandtotal').numberbox({
        label: 'Grand Total',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        min: 0,
        precision: 2
    });

    /**
     * Row 6
     */
    $('#status1').radiobutton({
        label: 'Tunai',
        value: 'T',
        labelPosition: 'before',
        checked: false
    });

    $('#status2').radiobutton({
        label: 'Kredit',
        value: 'K',
        labelPosition: 'before',
        checked: true
    });

    $('#keterangan').textbox({
        label: 'Keterangan',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600
    });

    /**
     * Row 7
     */
    $('#dttipe').textbox({
        label: 'Tipe Harga',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        valueField: 'nama_tipe'
    });

});