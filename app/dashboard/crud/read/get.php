<?php
/**
 * Wajib include di semua CRUD
 */
spl_autoload_register(function ($class_name) {
    $php_self_exp = explode('/', $_SERVER['PHP_SELF']);
    include($_SERVER['DOCUMENT_ROOT'] . '/'.$php_self_exp[1].'/config/system/' . $class_name . '.php');
});
$app = new App();
//==================

$data = $app->eloquent()->table('gudang')
    ->join('gudang_user', 'gudang.id', '=', 'gudang_user.kode_gdg')
    ->where('gudang_user.kode_user', 'fauzan')
    ->where('gudang.id', '<>', '%')
    ->get();

?>
<pre>
    <?= print_r($data) ?>
</pre>
