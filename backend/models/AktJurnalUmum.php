<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_jurnal_umum".
 *
 * @property int $id_jurnal_umum
 * @property int $no_jurnal_umum
 * @property int $tanggal
 * @property int $tipe
 */
class AktJurnalUmum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_jurnal_umum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_jurnal_umum', 'tanggal', 'tipe'], 'required'],
            [['no_jurnal_umum', 'tanggal', 'keterangan'], 'safe'],
            [['tipe'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jurnal_umum' => 'Id Jurnal Umum',
            'no_jurnal_umum' => 'No Jurnal Umum',
            'tanggal' => 'Tanggal',
            'tipe' => 'Tipe',
            'keterangan' => 'Keterangan',
        ];
    }

    public static function getKodeJurnalUmum()
    {
        $akt_jurnal_umum = AktJurnalUmum::find()
            ->select(["no_jurnal_umum"])
            ->orderBy("no_jurnal_umum DESC")
            ->limit(1)
            ->one();

        $no_jurnal_umum = '';

        if (!empty($akt_jurnal_umum->no_jurnal_umum)) {
            # code...
            $no_bulan = substr($akt_jurnal_umum->no_jurnal_umum, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_jurnal_umum->no_jurnal_umum, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_jurnal_umum = 'JU' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_jurnal_umum = 'JU' . date('ym') . '001';
            }
        } else {
            # code...
            $no_jurnal_umum = 'JU' . date('ym') . '001';
        }

        return $no_jurnal_umum;
    }
}
