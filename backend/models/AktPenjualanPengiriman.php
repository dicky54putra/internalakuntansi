<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penjualan_pengiriman".
 *
 * @property int $id_penjualan_pengiriman
 * @property string $no_pengiriman
 * @property string $tanggal_pengiriman
 * @property string $pengantar
 * @property string $keterangan_pengantar
 * @property string $foto_resi
 * @property int $id_penjualan
 * @property int $id_mitra_bisnis_alamat
 * @property string $penerima
 * @property string $keterangan_penerima
 */
class AktPenjualanPengiriman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penjualan_pengiriman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_pengiriman', 'tanggal_pengiriman', 'pengantar', 'id_penjualan', 'id_mitra_bisnis_alamat'], 'required'],
            [['tanggal_pengiriman', 'tanggal_penerimaan'], 'safe'],
            [['keterangan_pengantar', 'keterangan_penerima'], 'string'],
            [['id_penjualan', 'id_mitra_bisnis_alamat', 'status'], 'integer'],
            [['no_pengiriman', 'pengantar', 'penerima'], 'string', 'max' => 200],
            [['foto_resi'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan_pengiriman' => 'Id Penjualan Pengiriman',
            'no_pengiriman' => 'No Pengiriman',
            'tanggal_pengiriman' => 'Tanggal Pengiriman',
            'pengantar' => 'Pengantar',
            'keterangan_pengantar' => 'Keterangan Pengantar',
            'foto_resi' => 'Foto Resi',
            'id_penjualan' => 'Id Penjualan',
            'id_mitra_bisnis_alamat' => 'Alamat Pengantaran',
            'penerima' => 'Penerima',
            'keterangan_penerima' => 'Keterangan Penerima',
        ];
    }

    public function getmitra_bisnis_alamat()
    {
        return $this->hasOne(AktMitraBisnisAlamat::className(), ['id_mitra_bisnis_alamat' => 'id_mitra_bisnis_alamat']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->foto_resi) {
                $filename = time() . "_" . str_replace(" ", "_", $this->foto_resi->baseName) . '.' . $this->foto_resi->extension;
                $this->foto_resi->saveAs('upload/' . $filename);
                $this->foto_resi = $filename;
            } else {
                if ($this->isNewRecord) {
                    # code...
                } else {
                    # code...
                    $id_penjualan_pengiriman = $this->id_penjualan_pengiriman;
                    $penjualan_pengiriman = AktPenjualanPengiriman::findOne($id_penjualan_pengiriman);
                    $this->foto_resi = $penjualan_pengiriman->foto_resi;
                }
            }
            return true;
        }
    }
}
