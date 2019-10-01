<script type="text/javascript">
    'use strict'

    /**
     * Set tabs by menu
     */

    function addTabsByIdItem(id, item_target) {
        if (id == 'to_penjualan') {
            var config = {
                enable_menu: item_target,
                menu_id: '#m_transaksi',
                tab_title: 'Transaksi | Penjualan',
                tab_href: componentPath('transaksi/penjualan/component/index.php'),
            }
        }
        if (id == 'to_dashboard') {
            var config = {
                enable_menu: item_target,
                menu_id: '#m_dashboard',
                tab_title: 'Dashboard',
                tab_href: componentPath('dashboard/index.php'),
            }
        }
        return tabConfig(config);
    }
    //===================================

    function componentPath(path) {
        return 'app/'+path;
    }

    /**
     * Konfigurasi tabs
     */
    function tabConfig(config) {
        var config_tab = {
            title: config.tab_title,
            closable: false,
            href: config.tab_href,
            tools: [{
                iconCls: 'icon-no',
                handler: function() {
                    $(config.menu_id).menu('enableItem', config.enable_menu);
                    $('#app_tabs').tabs('close', config.tab_title);
                }
            }]
        }
        return $('#app_tabs').tabs('add', config_tab);
    }

    /**
     * Deklarasi menu list
     * Menu file
     * DOC : https://www.jeasyui.com/documentation/index.php
     */
    $('#mb_file').menubutton({
        menu: '#m_file'
    });
    //--------------
    var route_file = $('#m_file');
    route_file.menu({
        onClick: function(item) {
            var id_menu = item.id;
            addTabsByIdItem(id_menu, item.target);
            route_file.menu('disableItem', item.target);
        }
    });
    //===============

    /**
     * Menu transaksi
     */
    $('#mb_transaksi').menubutton({
        menu: '#m_transaksi'
    });
    //--------------
    var route_transaksi = $('#m_transaksi');
    route_transaksi.menu({
        onClick: function(item) {
            var id_menu = item.id;
            addTabsByIdItem(id_menu, item.target);
            route_transaksi.menu('disableItem', item.target);
        }
    });
    //================

    /**
     * Menu kas
     */
    $('#mb_kas').menubutton({
        menu: '#m_kas'
    });
    //--------------
    var route_kas = $('#m_kas');
    route_kas.menu({
        onClick: function(item) {
            var id_menu = item.id;
            addTabsByIdItem(id_menu, item.target);
            route_kas.menu('disableItem', item.target);
        }
    });
    //================

    /**
     * Menu accounting
     */
    $('#mb_accounting').menubutton({
        menu: '#m_accounting'
    });
    //--------------
    var route_accounting = $('#m_accounting');
    route_accounting.menu({
        onClick: function(item) {
            var id_menu = item.id;
            addTabsByIdItem(id_menu, item.target);
            route_accounting.menu('disableItem', item.target);
        }
    });
    //================

    /**
     * Menu laporan
     */
    $('#mb_laporan').menubutton({
        menu: '#m_laporan'
    });
    //--------------
    var route_laporan = $('#m_laporan');
    route_laporan.menu({
        onClick: function(item) {
            var id_menu = item.id;
            addTabsByIdItem(id_menu, item.target);
            route_laporan.menu('disableItem', item.target);
        }
    });
    //================

    /**
     * Menu proses
     */
    $('#mb_proses').menubutton({
        menu: '#m_proses'
    });
    //--------------
    var route_proses = $('#m_proses');
    route_proses.menu({
        onClick: function(item) {
            var id_menu = item.id;
            addTabsByIdItem(id_menu, item.target);
            route_proses.menu('disableItem', item.target);
        }
    });
    //================

    /**
     * Menu Dashboard
     */
    $('#mb_dashboard').menubutton({
        menu: '#m_dashboard'
    });
    //--------------
    var route_dashboard = $('#m_dashboard');
    route_dashboard.menu({
        onClick: function(item) {
            var id_menu = item.id;
            addTabsByIdItem(id_menu, item.target);
            route_dashboard.menu('disableItem', item.target);
        }
    });
    //================
</script>