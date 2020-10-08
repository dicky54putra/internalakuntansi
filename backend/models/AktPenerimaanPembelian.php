<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penerimaan_pembelian".
 *
 * @property int $id_penerimaan_pembelian
 * @property string $no_penerimaan
 * @property string $no_ref
 * @property string $tanggal
 * @property int $id_supplier
 * @property int $id_penerima
 * @property string $status_invoiced
 * @property string $keterangan
 * @property int $id_cabang
 * @property int $draft
 */
class AktPenerimaanPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penerimaan_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_penerimaan', 'no_ref', 'tanggal', 'status_invoiced', 'keterangan', 'draft'], 'required'],
            [['tanggal'], 'safe'],
            [['id_supplier', 'id_penerima', 'id_cabang', 'draft'], 'integer'],
            [['keterangan'], 'string'],
            [['no_penerimaan', 'no_ref', 'status_invoiced'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penerimaan_pembelian' => 'Id Penerimaan Pembelian',
            'no_penerimaan' => 'No Penerimaan',
            'no_ref' => 'No Ref',
            'tanggal' => 'Tanggal',
            'id_supplier' => 'Id Supplier',
            'id_penerima' => 'Id Penerima',
            'status_invoiced' => 'Status Invoiced',
            'keterangan' => 'Keterangan',
            'id_cabang' => 'Id Cabang',
            'draft' => 'Draft',
        ];
    }
}
