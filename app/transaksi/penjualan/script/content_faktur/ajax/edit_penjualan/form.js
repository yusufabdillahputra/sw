$(document).ready(function () {
    'use strict'

    var component_location = 'app/transaksi/penjualan';
    var panel_edit = $('#panel_edit_penjualan');
    var numberbox_diskonpersen = $('#e_diskonpersen');
    var numberbox_diskonrp = $('#e_diskonrp');

    panel_edit.panel({
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
    $('#e_no_faktur').textbox({
        label: 'No Faktur',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        required: true
    });

    $('#e_dtjth_tempo').textbox({
        label: 'Tgl Jth Tempo',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
    });

    /**
     * Row 2
     */
    $('#e_dtgudang').combobox({
        valueField: 'id',
        textField: 'nama',
        label: 'Gudang',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        url: component_location + '/crud/read/get_data_gudang.php'
    });

    $('#e_total').numberbox({
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
    $('#e_dtcustomer').combobox({
        label: 'Customer',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        valueField: 'id',
        textField: 'nama',
        url: component_location + '/crud/read/get_customer.php',
        onSelect: function (rec) {
            $('#e_dttipe').textbox('setValue', rec.nama_tipe);
            $('#e_dtjth_tempo').textbox('setValue', rec.tgl_jth_tempo);
            $('#e_dttanggal').datebox('setValue', rec.tgl_transaksi);

            /**
             * Set value dom yang akan digunakan untuk tipe costumer
             */
            $('#e_dt_kode_tipe').val(rec.kode_tipe);
            /**
             * Set properti dg_penjualan
             */
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
                    dt_faktur++;

                    var vfaktur = '000' + dt_faktur;
                    var dt_gudang = $('#e_dtgudang').combobox('getValue');

                    var no_faktur = dt_comp + '/' + vfaktur + '/' + dt_blnthn + '/' + dt_gudang + '/JB';

                    console.log('ini auto faktur', no_faktur);
                    $('#e_no_faktur').textbox('setValue', no_faktur);
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
            var total = parseInt($('#e_total').numberbox('getValue'));
            var jumlah = (parseInt(newValue) / 100) * total;
            var parsing_total = total - (jumlah + numberbox_diskonrp.numberbox('getValue'));
            $('#e_grandtotal').numberbox('setValue', parsing_total);
        }
    });

    /**
     * Row 4
     */
    $('#e_dttanggal').datebox({
        label: 'Tanggal',
        labelWidth: 100,
        labelPosition: 'before',
        width: 300,
        required: true,
        formatter: function (date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
        },
        parser: function (s) {
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var d = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(d, m - 1, y);
            } else {
                return new Date();
            }
        }
    });

    $('#e_dtmobil').combobox({
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
            var total = parseInt($('#e_total').numberbox('getValue'));
            var convert_persen = (parseInt(numberbox_diskonpersen.numberbox('getValue')) / 100) * total;
            var parsing_total = total - (parseInt(newValue) + convert_persen);
            $('#e_grandtotal').numberbox('setValue', parsing_total);
        }
    });

    /**
     * Row 5
     */
    $('#e_salesman').combobox({
        label: 'Salesman',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        valueField: 'id',
        textField: 'nama',
        url: component_location + '/crud/read/get_data_sales.php'
    });

    $('#e_grandtotal').numberbox({
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
    $('#e_status1').radiobutton({
        label: 'Tunai',
        value: 'T',
        labelPosition: 'before',
        checked: false
    });

    $('#e_status2').radiobutton({
        label: 'Kredit',
        value: 'K',
        labelPosition: 'before',
        checked: true
    });

    $('#e_keterangan').textbox({
        label: 'Keterangan',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600
    });

    /**
     * Row 7
     */
    $('#e_dttipe').textbox({
        label: 'Tipe Harga',
        labelWidth: 100,
        labelPosition: 'before',
        width: 600,
        valueField: 'nama_tipe'
    });

});