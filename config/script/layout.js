$(document).ready(function () {
    $('body').layout();
    $('body').layout('add', {
        id: 'app_menu',
        region: 'north',
        split: true,
        href: 'config/router/menu/list.php'
    });
    $('body').layout('add', {
        id: 'app_content',
        region: 'center',
        split: true,
        href: 'app/tabs.php'
    });
});