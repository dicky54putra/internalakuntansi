<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenjualanHartaTetapDetail;

/**
 * AktPenjualanHartaTetapDetailSearch represents the model behind the search form of `backend\models\AktPenjualanHartaTetapDetail`.
 */
class AktPenjualanHartaTetapDetailSearch extends AktPenjualanHartaTetapDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan_harta_tetap_detail', 'id_penjualan_harta_tetap', 'id_pembelian_harta_tetap_detail', 'qty'], 'integer'],
            [['diskon'], 'number'],
            [['keterangan', 'harga', 'total'], 'safe'],
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
        $query = AktPenjualanHartaTetapDetail::find();

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
            'id_penjualan_harta_tetap_detail' => $this->id_penjualan_harta_tetap_detail,
            'id_penjualan_harta_tetap' => $this->id_penjualan_harta_tetap,
            'id_pembelian_harta_tetap_detail' => $this->id_pembelian_harta_tetap_detail,
            'qty' => $this->qty,
            'harga' => $this->harga,
            'diskon' => $this->diskon,
            'total' => $this->total,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
