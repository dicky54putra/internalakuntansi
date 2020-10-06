<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktItemPajakPembelian;

/**
 * AktItemPajakPembelianSearch represents the model behind the search form of `backend\models\AktItemPajakPembelian`.
 */
class AktItemPajakPembelianSearch extends AktItemPajakPembelian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_pajak_pembelian', 'id_item', 'id_pajak', 'perhitungan'], 'integer'],
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
        $query = AktItemPajakPembelian::find();

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
            'id_item_pajak_pembelian' => $this->id_item_pajak_pembelian,
            'id_item' => $this->id_item,
            'id_pajak' => $this->id_pajak,
            'perhitungan' => $this->perhitungan,
        ]);

        return $dataProvider;
    }
}
