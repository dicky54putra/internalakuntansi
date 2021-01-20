<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktReturPenjualan;

/**
 * AktReturPenjualanSearch represents the model behind the search form of `backend\models\AktReturPenjualan`.
 */
class AktReturPenjualanSearch extends AktReturPenjualan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_retur_penjualan', 'status_retur'], 'integer'],
            [['no_retur_penjualan', 'tanggal_retur_penjualan', 'id_penjualan'], 'safe'],
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
        $query = AktReturPenjualan::find();
        $query->joinWith("penjualan");
        $query->orderBy(['no_retur_penjualan' => SORT_DESC]);

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

        if (!empty($this->tanggal_retur_penjualan)) {
            $query->andFilterWhere(["date_format(tanggal_retur_penjualan, '%d-%m-%Y')" => $this->tanggal_retur_penjualan]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_retur_penjualan' => $this->id_retur_penjualan,
            'status_retur' => $this->status_retur,
        ]);

        $query->andFilterWhere(['like', 'no_retur_penjualan', $this->no_retur_penjualan])
            ->andFilterWhere(['like', 'akt_penjualan.no_penjualan', $this->id_penjualan]);

        return $dataProvider;
    }
}
