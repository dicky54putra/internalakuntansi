<?php

namespace backend\models;
use yii\base\Model;
use backend\models\AktItemStok;
use Yii;

/**
 * This is the model class for table "akt_stok_opname_detail".
 *
 * @property int $id_stok_opname_detail
 * @property int $id_stok_opname
 * @property int $id_item_stok
 * @property int $qty
 * @property int $qty_program
 * @property int $qty_selisih
 */
class AktStokOpnameDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_stok_opname_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_opname', 'id_item_stok', 'qty_opname', 'qty_program', 'qty_selisih'], 'required'],
            [['id_stok_opname', 'id_item_stok', 'qty_opname', 'qty_program'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_opname_detail' => 'Id Stok Opname Detail',
            'id_stok_opname' => 'Id Stok Opname',
            'id_item_stok' => 'Barang',
            'qty_opname' => 'Qty Opname',
            'qty_program' => 'Qty Program',
            'qty_selisih' => 'Qty Selisih',
        ];
    }

    public static function getHistoryTransaksi($id){

        $akt_history_transaksi = AktHistoryTransaksi::find()
        ->where(['nama_tabel' => 'akt_stok_opname'])
        ->andWhere(['id_tabel' => $id])->one();

        return $akt_history_transaksi;
    }

    public static function getJurnalUmumDetail($id, $id_jurnal_umum){

        $jurnal_umum_detail = AktJurnalUmumDetail::find()
        ->where(['id_akun' => $id])
        ->andWhere(['id_jurnal_umum' => $id_jurnal_umum])
        ->one();

        return $jurnal_umum_detail;
    }

    public function getDataTable($db, $where, $id,  $get = 'one'){

        $modelName = 'backend\models\\' . $db;
        if($get == 'one') {
            $table = $modelName::find()->where([$where => $id])->one();
        } else if ($get == 'all') {
            $table = $modelName::find()->where([$where => $id])->all();
        }

        return $table;
    }
}
