<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktSaldoAwalStokDetail;

/**
 * AktSaldoAwalStokDetailSearch represents the model behind the search form of `backend\models\AktSaldoAwalStokDetail`.
 */
class AktSaldoAwalStokDetailSearch extends AktSaldoAwalStokDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_saldo_awal_stok_detail', 'id_saldo_awal_stok', 'id_item', 'id_item_stok', 'qty'], 'integer'],
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
        $query = AktSaldoAwalStokDetail::find();

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
            'id_saldo_awal_stok_detail' => $this->id_saldo_awal_stok_detail,
            'id_saldo_awal_stok' => $this->id_saldo_awal_stok,
            'id_item' => $this->id_item,
            'id_item_stok' => $this->id_item_stok,
            'qty' => $this->qty,
        ]);

        return $dataProvider;
    }
}
