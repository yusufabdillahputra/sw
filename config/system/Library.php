<?php

class Library extends SQLAnywhere {

    public function __construct()
    {
        parent::__construct();
    }

    public function fCekPlafoncust($ls_cust){
        $sql = "declare 
                    @li_tol INT, 
                    @li_tol1 INT, 
                    @li_tol2 INT, 
                    @ls_prioritas TEXT, 
                    @ld_tglmin DATE
                select 
                    @li_tol = payment_due, 
                    @li_tol1 = toleransi1, 
                    @li_tol2 = toleransi2, 
                    @ls_prioritas = prioritas, 
                    @ld_tglmin = min_tanggal
                from customer 
                where
                    id = '$ls_cust'
                select 
                    @li_tol as li_tol, 
                    @li_tol1 as li_tol1, 
                    @li_tol2 as li_tol2, 
                    @ls_prioritas as ls_prioritas, 
                    @ld_tglmin as ld_tglmin";

        $result = parent::get($sql, false);
        foreach ($result as $value) {
            $li_tol       = $value['li_tol'];
            $li_tol1      = $value['li_tol1'];
            $li_tol2      = $value['li_tol2'];
            $ls_prioritas = $value['ls_prioritas'];
            $ld_tglmin    = $value['ld_tglmin'];
        }

        /**
         * todo : $date1 ini cuma percobaan, data yang seharusnya dipakai adalah $ld_tglmin
         */
        $date1  = date_create("2019-10-15");

        $gd_tgl = date_create(Date("Y-m-d"));
        $diff   = date_diff($date1,$gd_tgl);
        $interval = $diff->format("%a");

        if ($ls_prioritas == '1') { //putih
            $li_ret = 1;
        }else{
            if ($interval <= $li_tol) { //hijau
                $li_ret = 2;
            } elseif ($interval <= $li_tol1) { //biru
                $li_ret = 3;
            } elseif ($interval <= $li_tol2) { //merah
                $li_ret = 4;
            } elseif ($interval > $li_tol2) { // abu-abu
                $li_ret = 5;
            } else { //tidak ada hutang
                $li_ret = 2;
            }
        }

        return $li_ret;
    }

}
