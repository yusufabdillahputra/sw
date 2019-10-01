<?php
$conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");
$sql = "SELECT barang.* FROM barang";
$query = sasql_query($conn, $sql);
$result = array();
while ($row = sasql_fetch_array($query)) {
    array_push($result, [
        'barang' => $row['ID'],
        'productname' => $row['NAMA']
    ]);
}
echo json_encode($result);