<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPembelianPenerimaanDetail;

/**
 * AktPembelianPenerimaanDetailSearch represents the model behind the search form of `backend\models\AktPembelianPenerimaanDetail`.
 */
class AktPembelianPenerimaanDetailSearch extends AktPembelianPenerimaanDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian_penerimaan_detail', 'id_pembelian_penerimaan', 'id_pembelian_detail', 'qty_diterima'], 'integer'],
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
        $query = AktPembelianPenerimaanDetail::find();

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
            'id_pembelian_penerimaan_detail' => $this->id_pembelian_penerimaan_detail,
            'id_pembelian_penerimaan' => $this->id_pembelian_penerimaan,
            'id_pembelian_detail' => $this->id_pembelian_detail,
            'qty_diterima' => $this->qty_diterima,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
