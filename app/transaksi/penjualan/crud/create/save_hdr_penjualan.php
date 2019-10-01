<?php

$dtno_faktur     = htmlspecialchars($_REQUEST['no_faktur']);
$no_faktur       = str_replace('/', '', $dtno_faktur);

$gudang          = htmlspecialchars($_REQUEST['gudang']);
$customer        = htmlspecialchars($_REQUEST['customer']);

$dttanggal       = htmlspecialchars($_REQUEST['tanggal']);
$tanggal         = date("Y-m-d", strtotime($dttanggal));

$mobil           = htmlspecialchars($_REQUEST['mobil']);
$salesman        = htmlspecialchars($_REQUEST['salesman']);
$status          = htmlspecialchars($_REQUEST['status']);
$kode_tipe       = htmlspecialchars($_REQUEST['kode_tipe']);

$dttgl_jth_tempo = htmlspecialchars($_REQUEST['tgl_jth_tempo']);
$dtdate = str_replace('/','-', $dttgl_jth_tempo);
$tgl_jth_tempo   = date("Y-m-d", strtotime($dtdate));

$total           = htmlspecialchars($_REQUEST['total']);
$diskonpersen    = htmlspecialchars($_REQUEST['diskonpersen']);
if ($diskonpersen == '' || $diskonpersen == NULL) {
    $dtdiskonpersen = 0.00;
} else {
    $dtdiskonpersen = $diskonpersen;
}

$diskonrp        = htmlspecialchars($_REQUEST['diskonrp']);
if ($diskonrp == '' || $diskonrp == NULL) {
    $dtdiskonrp = 0.00;
} else {
    $dtdiskonrp = $diskonrp;
}

$grandtotal = htmlspecialchars($_REQUEST['grandtotal']);
$keterangan = htmlspecialchars($_REQUEST['keterangan']);

$hpp        = htmlspecialchars($_REQUEST['hpp']);
$profit     = htmlspecialchars($_REQUEST['profit']);

//echo $no_faktur."/-/".$gudang."/-/".$customer."/-/".$tanggal."/-/".$mobil."/-/".$salesman."/-/".$status."/-/".$kode_tipe."/-/".$tgl_jth_tempo."/-/".$total."/-/".$diskonpersen."/-/".$diskonrp."/-/".$grandtotal."/-/".$keterangan;

$conn = sasql_connect("ServerName=sejahtera;uid=DBA;PWD=fauzan123");
$sql = "insert into master_jual(no_faktur,gudang,cust_id,tanggal,kendaraan,sales_id,status,kode_tipe,jth_tempo,total,discountp,discountn,grandtotal,ket,tipe,issuedby,flag_hrgtipe,profit,hpp) values('$no_faktur','$gudang','$customer','$tanggal','$mobil','$salesman','$status','$kode_tipe','$tgl_jth_tempo','$total','$dtdiskonpersen','$dtdiskonrp','$grandtotal','$keterangan','J','fauzan','1','$profit','$hpp')";
$result = sasql_query($conn, $sql);
if ($result) {
    echo json_encode(
        array(
            'no_faktur'     => $no_faktur,
            'gudang'        => $gudang,
            'customer'      => $customer,
            'tanggal'       => $dttanggal,
            'mobil'         => $mobil,
            'salesman'      => $salesman,
            'status'        => $status,
            'kode_tipe'     => $kode_tipe,
            'tgl_jth_tempo' => $dttgl_jth_tempo,
            'total'         => $total,
            'diskonpersen'  => $diskonpersen,
            'diskonrp'      => $diskonrp,
            'grandtotal'    => $grandtotal,
            'keterangan'    => $keterangan,
            'hpp'           => $hpp,
            'profit'        => $profit
        )
    );
} else {
    echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>