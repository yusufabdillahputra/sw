<?php
$conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");
$sql = "select * from gudang as gdg join gudang_user as gdg_user on gdg.id = gdg_user.kode_gdg where gdg_user.kode_user = 'fauzan' and gdg.id <> '%'";
$query = sasql_query($conn, $sql);
$result = array();
while ($row = sasql_fetch_array($query)) {
    array_push($result, [
        'id' => $row['id'],
        'nama' => $row['name']
    ]);
}
echo json_encode($result);
?>