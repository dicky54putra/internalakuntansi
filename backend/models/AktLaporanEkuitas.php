<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_laporan_ekuitas".
 *
 * @property int $id_laporan_ekuitas
 * @property int $id_laba_rugi
 * @property int $prive
 * @property int $modal
 * @property int $laba_bersih
 */
class AktLaporanEkuitas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_laporan_ekuitas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_laba_rugi', 'prive', 'modal', 'laba_bersih'], 'required'],
            [['id_laba_rugi', 'prive', 'modal', 'laba_bersih'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_laporan_ekuitas' => 'Id Laporan Ekuitas',
            'id_laba_rugi' => 'Id Laba Rugi',
            'prive' => 'Prive',
            'modal' => 'Modal',
            'laba_bersih' => 'Laba Bersih',
        ];
    }
}
