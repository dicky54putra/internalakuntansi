<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktSaldoAwalStok;

/**
 * AktSaldoAwalStokiSearch represents the model behind the search form of `backend\models\AktSaldoAwalStok`.
 */
class AktSaldoAwalStokSearch extends AktSaldoAwalStok
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_saldo_awal_stok', 'tipe'], 'integer'],
            [['no_transaksi', 'tanggal'], 'safe'],
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
        $query = AktSaldoAwalStok::find();

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
            'id_saldo_awal_stok' => $this->id_saldo_awal_stok,
            'tanggal' => $this->tanggal,
            'tipe' => $this->tipe,
        ]);

        $query->andFilterWhere(['like', 'no_transaksi', $this->no_transaksi]);

        return $dataProvider;
    }
}
