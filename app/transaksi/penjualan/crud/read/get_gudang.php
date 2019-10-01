<?php
$conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");
$sql = "SELECT id, name FROM gudang where id <> '%'";
$query = sasql_query($conn,$sql);
$result = array();
while ($row = sasql_fetch_array($query)) {
    array_push($result, [
        'id' => $row['id'],
        'nama_gudang' => $row['name']
    ]);
}

print json_encode($result);