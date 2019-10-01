<?php
$conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");
$sql = "declare @is_faktur int, @is_blnthn text, @gs_comp int

select @gs_comp = max(comp_id) from master_jual
select @is_faktur = max(substring(no_faktur,3,4)) from master_jual
select @is_blnthn = dateformat(NOW(), 'mmyy')

select @gs_comp as dt_comp_id, @is_faktur as dt_faktur, @is_blnthn as dt_blnthn";
$query = sasql_query($conn, $sql);
while ($row = sasql_fetch_array($query)) {
    $result = array(
        'comp_id' => $row['dt_comp_id'],
        'faktur' => $row['dt_faktur'],
        'blnthn' => $row['dt_blnthn']
    );
}

echo json_encode($result);
?>