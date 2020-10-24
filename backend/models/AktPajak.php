<?php

namespace backend\models;

use Yii;
use backend\models\AktAkun;

/**
 * This is the model class for table "akt_pajak".
 *
 * @property int $id_pajak
 * @property string $nama_pajak
 * @property int $id_akun_pembelian
 * @property int $id_akun_penjualan
 * @property string $presentasi_npwp
 * @property string $presentasi_non_npwp
 */
class AktPajak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pajak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_pajak','nama_pajak', 'id_akun_pembelian', 'id_akun_penjualan', 'presentasi_npwp', 'presentasi_non_npwp'], 'required'],
            [['id_akun_pembelian', 'id_akun_penjualan'], 'integer'],
            [['kode_pajak','nama_pajak', 'presentasi_npwp', 'presentasi_non_npwp'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pajak' => 'Id Pajak',
            'kode_pajak' => 'Kode Pajak',
            'nama_pajak' => 'Nama Pajak',
            'id_akun_pembelian' => 'Akun Pembelian',
            'id_akun_penjualan' => 'Akun Penjualan',
            'presentasi_npwp' => 'Presentasi NPWP',
            'presentasi_non_npwp' => 'Presentasi Non NPWP',
        ];
    }

    public function getAkunPembelian()
    {
        return $this->hasOne(AktAkun::className(), ['id_akun' => 'id_akun_pembelian']);
    }

    public function getAkunPenjualan()
    {
        return $this->hasOne(AktAkun::className(), ['id_akun' => 'id_akun_penjualan']);
    }
}
