<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penyesuaian_stok_detail".
 *
 * @property int $id_penyesuaian_stok_detail
 * @property int $id_penyesuaian_stok
 * @property int $id_item_stok
 * @property int $qty
 * @property int $hpp
 * @property int $id_gudang
 */
class AktPenyesuaianStokDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penyesuaian_stok_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penyesuaian_stok', 'id_item_stok', 'qty'], 'required'],
            [['id_penyesuaian_stok', 'id_item_stok', 'qty'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penyesuaian_stok_detail' => 'Id Penyesuaian Stok Detail',
            'id_penyesuaian_stok' => 'Id Penyesuaian Stok',
            'id_item_stok' => 'Item',
            'qty' => 'Qty'
        ];
    }

    public function getDataTable($db, $where, $id,  $get = 'one')
    {

        $modelName = 'backend\models\\' . $db;
        if ($get == 'one') {
            $table = $modelName::find()->where([$where => $id])->one();
        } else if ($get == 'all') {
            $table = $modelName::find()->where([$where => $id])->all();
        }

        return $table;
    }

    public static function getHistoryTransaksi($id)
    {

        $akt_history_transaksi = AktHistoryTransaksi::find()
            ->where(['nama_tabel' => 'akt_penyesuaian_stok'])
            ->andWhere(['id_tabel' => $id])->one();

        return $akt_history_transaksi;
    }

    public static function getJurnalUmumDetail($id, $id_jurnal_umum)
    {

        $jurnal_umum_detail = AktJurnalUmumDetail::find()
            ->where(['id_akun' => $id])
            ->andWhere(['id_jurnal_umum' => $id_jurnal_umum])
            ->one();

        return $jurnal_umum_detail;
    }
}
