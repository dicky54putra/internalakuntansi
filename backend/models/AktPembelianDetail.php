<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "akt_pembelian_detail".
 *
 * @property int $id_pembelian_detail
 * @property int $id_pembelian
 * @property int $id_item_stok
 * @property int $qty
 * @property int $harga
 * @property int $diskon
 * @property int $total
 * @property string $keterangan
 */
class AktPembelianDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembelian_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian'], 'required'],
            [['id_pembelian', 'id_item_stok', 'qty', 'total'], 'integer'],
            [['diskon'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian_detail' => 'Id Pembelian Detail',
            'id_pembelian' => 'Id Pembelian',
            'id_item_stok' => 'Id Item Stok',
            'qty' => 'Qty',
            'harga' => 'Harga',
            'diskon' => 'Diskon',
            'total' => 'Total',
            'keterangan' => 'Keterangan',
        ];
    }

    public static function dataItemStok()
    {
        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty", "akt_satuan.nama_satuan"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->leftJoin("akt_satuan", "akt_satuan.id_satuan = akt_item.id_satuan")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return 'Nama Barang : ' . $model['nama_item'] . ', Satuan : ' . $model['nama_satuan'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );

        return $data_item_stok;
    }
}
