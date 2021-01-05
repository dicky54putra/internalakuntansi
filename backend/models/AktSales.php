<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "akt_sales".
 *
 * @property int $id_sales
 * @property string $kode_sales
 * @property string $nama_sales
 * @property string $alamat
 * @property int $id_kota
 * @property int $kode_pos
 * @property int $telepon
 * @property int $handphone
 * @property string $email
 * @property int $status_aktif
 */
class AktSales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_sales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_sales', 'nama_sales', 'alamat', 'id_kota'], 'required'],
            [['alamat'], 'string'],
            [['id_kota', 'status_aktif'], 'integer'],
            [['kode_sales', 'kode_pos', 'telepon', 'handphone'], 'string', 'max' => 20],
            [['nama_sales', 'email'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_sales' => 'Id Sales',
            'kode_sales' => 'Kode Sales',
            'nama_sales' => 'Nama Sales',
            'alamat' => 'Alamat',
            'id_kota' => 'Kota',
            'kode_pos' => 'Kode Pos',
            'telepon' => 'Telepon',
            'handphone' => 'Handphone',
            'email' => 'Email',
            'status_aktif' => 'Status',
        ];
    }

    public function getakt_kota()
    {
        return $this->hasOne(AktKota::className(), ['id_kota' => 'id_kota']);
    }

    public static function getArrayKota($model)
    {
        $data =  ArrayHelper::map(AktKota::find()->all(), 'id_kota', function ($model) {
            return $model->kode_kota . ' - ' . $model->nama_kota;
        });
        return $data;
    }
}
