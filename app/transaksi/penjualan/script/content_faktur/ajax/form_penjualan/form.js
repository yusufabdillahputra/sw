$(document).ready(function () {
    'use strict'

    var component_location = 'app/transaksi/penjualan';

    var numberbox_diskonpersen = $('#diskonpersen');
    var numberbox_diskonrp = $('#diskonrp');

    $('#status1').radiobutton({
        label: 'Tunai',
        value: 'T',
        labelPosition: 'after',
        checked: false
    });

    $('#status2').radiobutton({
        label: 'Kredit',
        value: 'K',
        labelPosition: 'after',
        checked: true
    });

    $('#dttanggal').datebox({
        label: 'Tanggal:',
        required: true,
        formatter: function (date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
        },
        parser: function(s) {
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

    $('#dtcustomer').combobox({
        valueField: 'id',
        textField: 'nama',
        url: component_location + '/crud/read/get_customer.php',
        onSelect: function (rec) {
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
                    dt_faktur++;

                    var vfaktur = '000' + dt_faktur;
                    var dt_gudang = $('#dtgudang').combobox('getValue');

                    var no_faktur = dt_comp + '/' + vfaktur + '/' + dt_blnthn + '/' + dt_gudang + '/JB';

                    console.log('ini auto faktur', no_faktur);
                    $('#no_faktur').textbox('setValue', no_faktur);
                }
            });
        }
    });

    $('#dtmobil').combobox({
        valueField: 'id',
        textField: 'nama',
        url: component_location + '/crud/read/get_data_sales.php'
    });

    $('#dtmobil').combobox({
        valueField: 'id',
        textField: 'nama',
        url: component_location + '/crud/read/get_data_mobil.php'
    });

    $('#dtgudang').combobox({
        valueField: 'id',
        textField: 'nama',
        url: component_location + '/crud/read/get_data_gudang.php'
    });

    numberbox_diskonpersen.numberbox({
        label: 'Discount %',
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

    numberbox_diskonrp.numberbox({
        label: 'Discount Rp',
        min: 0,
        precision: 2,
        onChange: function (newValue, oldValue) {
            var total = parseInt($('#total').numberbox('getValue'));
            var convert_persen = (parseInt(numberbox_diskonpersen.numberbox('getValue')) / 100) * total;
            var parsing_total = total - (parseInt(newValue) + convert_persen);
            $('#grandtotal').numberbox('setValue', parsing_total);
        }
    });

});