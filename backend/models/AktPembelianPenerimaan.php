<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pembelian_penerimaan".
 *
 * @property int $id_pembelian_penerimaan
 * @property string $no_penerimaan
 * @property string $tanggal_penerimaan
 * @property string $penerima
 * @property string $foto_resi
 * @property int $id_pembelian
 * @property string $pengantar
 * @property string $keterangan_pengantar
 */
class AktPembelianPenerimaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembelian_penerimaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_penerimaan', 'tanggal_penerimaan', 'penerima', 'id_pembelian', 'pengantar'], 'required'],
            [['tanggal_penerimaan'], 'safe'],
            [['id_pembelian'], 'integer'],
            [['keterangan_pengantar'], 'string'],
            [['no_penerimaan', 'pengantar'], 'string', 'max' => 200],
            [['penerima'], 'string', 'max' => 255],
            [['foto_resi'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian_penerimaan' => 'Pembelian Penerimaan',
            'no_penerimaan' => 'No Penerimaan',
            'tanggal_penerimaan' => 'Tanggal Penerimaan',
            'penerima' => 'Penerima',
            'foto_resi' => 'Foto Resi',
            'id_pembelian' => 'Pembelian',
            'pengantar' => 'Pengantar',
            'keterangan_pengantar' => 'Keterangan Pengantar',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->foto_resi) {
                $filename = time() . "_" . str_replace(" ", "_", $this->foto_resi->baseName) . '.' . $this->foto_resi->extension;
                $this->foto_resi->saveAs('upload/' . $filename);
                $this->foto_resi = $filename;
            } else {
                $this->foto_resi = " ";
            }
            return true;
        }
    }

    public function getmitra_bisnis_alamat()
    {
        return $this->hasOne(AktMitraBisnisAlamat::className(), ['id_mitra_bisnis_alamat' => 'id_mitra_bisnis_alamat']);
    }
}
