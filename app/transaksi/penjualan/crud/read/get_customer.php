<?php
$conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");
$sql = "select cs.id, cs.nama, cs.kode_tipe, th.nama_tipe, dateformat(dateadd(day, cs.payment_due, NOW()),'dd/mm/yyyy') as tgl_jth_tempo, dateformat(NOW(), 'mm/dd/yyyy') as tgl_transaksi from customer cs, tipe_harga th where cs.kode_tipe = th.kode_tipe";
$query = sasql_query($conn, $sql);
$result = array();
while ($row = sasql_fetch_array($query)) {
    array_push($result, [
        'id' => $row['id'],
        'nama' => $row['nama'],
        'kode_tipe' => $row['kode_tipe'],
        'nama_tipe' => $row['nama_tipe'],
        'tgl_jth_tempo' => $row['tgl_jth_tempo'],
        'tgl_transaksi' => $row['tgl_transaksi']
    ]);
}
echo json_encode($result);
?>