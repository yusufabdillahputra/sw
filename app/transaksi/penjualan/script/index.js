$(document).ready(function() {
    'use strict'

    var component_location = 'app/transaksi/penjualan/component';

    $('#p_index').panel();
    $('#ly_index').layout();
    $('#ly_index').layout('add', {
        id: 'menu_faktur',
        region: 'west',
        split: true,
        minWidth: 300,
        maxWidth: 400,
        collapsible:false,
        href: component_location+'/menu_faktur/index.php'
    });
    $('#ly_index').layout('add', {
        id: 'content_faktur',
        region: 'center',
        split: true,
        collapsible:false,
        href: component_location+'/content_faktur/index.php'
    });
});