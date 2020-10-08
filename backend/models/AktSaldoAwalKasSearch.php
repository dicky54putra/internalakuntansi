<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktSaldoAwalKas;

/**
 * AktSaldoAwalKasSearch represents the model behind the search form of `backend\models\AktSaldoAwalKas`.
 */
class AktSaldoAwalKasSearch extends AktSaldoAwalKas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_saldo_awal_kas', 'jumlah'], 'integer'],
            [['no_transaksi', 'tanggal_transaksi', 'keterangan', 'id_kas_bank'], 'safe'],
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
        $query = AktSaldoAwalKas::find();
        $query->joinWith("kas_bank");

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
            'id_saldo_awal_kas' => $this->id_saldo_awal_kas,
            'tanggal_transaksi' => $this->tanggal_transaksi,
            // 'id_kas_bank' => $this->id_kas_bank,
            // 'jumlah' => $this->jumlah,
        ]);

        $query->andFilterWhere(['like', 'no_transaksi', $this->no_transaksi])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'jumlah', $this->jumlah])
            ->andFilterWhere(['like', 'akt_kas_bank.keterangan', $this->id_kas_bank]);

        return $dataProvider;
    }
}
