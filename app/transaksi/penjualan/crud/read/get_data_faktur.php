<?php
/**
 * Autoload (Wajib include di semua CRUD)
 */
spl_autoload_register(function ($class_name) {
    $php_self_exp = explode('/', $_SERVER['PHP_SELF']);
    include($_SERVER['DOCUMENT_ROOT'] . '/' . $php_self_exp[1] . '/config/system/' . $class_name . '.php');
});

/**
 * Path : root_path/config/SQLAnywhere
 */
$db = new SQLAnywhere();

/**
 * Proses CRUD
 * Contoh : $db->get('sql_script', 'json_condition', 'result_type')
 *
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */

$sql = "declare @is_faktur int, @is_blnthn text, @gs_comp int

select @gs_comp = kode_comp from company_user where kode_user = 'fauzan'
select @is_blnthn = dateformat(NOW(), 'mmyy')
select @is_faktur = max(substring(no_faktur,3,4)) from master_jual where right(left(no_faktur,10),4) = @is_blnthn and comp_id = @gs_comp

select @gs_comp as dt_comp_id, CASE WHEN @is_faktur IS NULL THEN 0 END as dt_faktur, @is_blnthn as dt_blnthn";
$fetch = $db->get($sql, false);

foreach ($fetch as $row) {
    $result = array(
        'comp_id' => $row['dt_comp_id'],
        'faktur' => sprintf('%05s',$row['dt_faktur']+1),
        'blnthn' => $row['dt_blnthn']
    );
}

print json_encode($result);