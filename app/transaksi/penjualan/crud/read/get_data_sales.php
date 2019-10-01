<?php
$conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");
$sql = "select id, nama from pegawai where tipe_peg = 'SLS'";
$query = sasql_query($conn, $sql);
$result = array();
while ($row = sasql_fetch_array($query)) {
    array_push($result, [
        'id' => $row['id'],
        'nama' => $row['nama']
    ]);
}
echo json_encode($result);
?>