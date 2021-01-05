<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenjualanPengirimanDetail;

/**
 * AktPenjualanPengirimanDetailSearch represents the model behind the search form of `backend\models\AktPenjualanPengirimanDetail`.
 */
class AktPenjualanPengirimanDetailSearch extends AktPenjualanPengirimanDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan_pengiriman_detail', 'id_penjualan_pengiriman', 'id_penjualan_detail', 'qty_dikirim'], 'integer'],
            [['keterangan'], 'safe'],
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
        $query = AktPenjualanPengirimanDetail::find();

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
            'id_penjualan_pengiriman_detail' => $this->id_penjualan_pengiriman_detail,
            'id_penjualan_pengiriman' => $this->id_penjualan_pengiriman,
            'id_penjualan_detail' => $this->id_penjualan_detail,
            'qty_dikirim' => $this->qty_dikirim,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
