<?php

namespace yii\helpers;

use Yii;

class Utils

{
    public static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

    public static function getIdLogin() {
        $id_login =  Yii::$app->user->identity->id_login;
        return $id_login;
    }

    public static function getNomorTransaksi($model, $kode, $select, $order)
    {


        $no_transaksi = '';
        $penyesuaian_kas = $model::find()->select([$select])->orderBy(" $order DESC")->limit(1)->one();
        if (!empty($penyesuaian_kas->$select)) {
            # code...
            $no_bulan = substr($penyesuaian_kas->$select, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($penyesuaian_kas->$select, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_transaksi = $kode . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_transaksi = $kode . date('ym') . '001';
            }
        } else {
            # code...
            $no_transaksi = $kode . date('ym') . '001';
        }

        return $no_transaksi;
    }
}
