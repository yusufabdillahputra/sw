$(document).ready(function() {
    'use strict'

    var component_location = 'app/transaksi/penjualan/component/content_faktur/ajax';

    /**
     * Insert config
     */
    $('#btn_insert').linkbutton({
        iconCls: 'icon-large-smartart',
        onClick: function() {
            $('#win_insert').window('open');
        }
    });

    $('#win_insert').window({
        top:40,
        width:1366,
        height:590,
        fit: false,
        modal: false,
        closed: true,
        iconCls: 'icon-edit',
        collapsible: false,
        minimizable: false,
        maximizable: true
    });
    $('#panel_insert').panel({
        href: component_location+'/insert_penjualan.php'
    });

    /**
     * Edit config
     */
    $('#btn_edit').linkbutton({
        iconCls: 'icon-edit',
        onClick: function() {
            alert("Edit");
        }
    });
    $('#win_edit').window({
        top:40,
        width:1366,
        height:590,
        fit: false,
        modal: false,
        closed: true,
        iconCls: 'icon-edit',
        collapsible: false,
        minimizable: false,
        maximizable: true
    });
    $('#panel_edit').panel({
        href: component_location+'/edit_penjualan.php'
    });

    /**
     * Delete config
     */
    $('#btn_delete').linkbutton({
        iconCls: 'icon-clear',
        onClick: function() {
            alert("Delete");
        }
    });

    /**
     * Retrieve config
     */
    $('#btn_retrieve').linkbutton({
        iconCls: 'icon-reload',
        onClick: function() {
            $('#win_retrieve').window('open');
        }
    });

    $('#win_retrieve').window({
        iconCls: 'icon-reload',
        fit: false,
        fitColumns: false,
        modal: true,
        closed: true,
        collapsible: false,
        minimizable: false,
        maximizable: false,
        width: 340,
        height: 220
    });
    $('#panel_retrieve').panel({
        fit:true,
        href: component_location+'/retrieve_penjualan.php'
    });

    /**
     * Retrieve print
     */
    $('#btn_print').linkbutton({
        iconCls: 'icon-print',
        onClick: function() {
            alert("Print");
            //$('#dg_menu_faktur').datagrid('toExcel','dg.xls');
            //$('#dg').datagrid('print','DataGrid');
        }
    });
});