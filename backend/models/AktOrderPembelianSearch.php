<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktOrderPembelian;

/**
 * AktOrderPembelianSearch represents the model behind the search form of `backend\models\AktOrderPembelian`.
 */
class AktOrderPembelianSearch extends AktOrderPembelian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_order_pembelian', 'id_supplier', 'id_mata_uang', 'id_cabang', 'total'], 'integer'],
            [['no_order', 'tanggal_order', 'status_order', 'keterangan', 'alamat_bayar', 'alamat_kirim'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AktOrderPembelian::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_order_pembelian' => $this->id_order_pembelian,
            'tanggal_order' => $this->tanggal_order,
            'id_supplier' => $this->id_supplier,
            'id_mata_uang' => $this->id_mata_uang,
            'id_cabang' => $this->id_cabang,
            'total' => $this->total,
        ]);

        $query->andFilterWhere(['like', 'no_order', $this->no_order])
            ->andFilterWhere(['like', 'status_order', $this->status_order])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'alamat_bayar', $this->alamat_bayar])
            ->andFilterWhere(['like', 'alamat_kirim', $this->alamat_kirim]);

        return $dataProvider;
    }
}
