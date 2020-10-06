<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPembayaranBiaya;

/**
 * AktPembayaranBiayaSearch represents the model behind the search form of `backend\models\AktPembayaranBiaya`.
 */
class AktPembayaranBiayaSearch extends AktPembayaranBiaya
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembayaran_biaya', 'id_pembelian', 'cara_bayar', 'id_kas_bank', 'nominal'], 'integer'],
            [['tanggal_pembayaran_biaya', 'keterangan'], 'safe'],
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
        $query = AktPembayaranBiaya::find();

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
            'id_pembayaran_biaya' => $this->id_pembayaran_biaya,
            'tanggal_pembayaran_biaya' => $this->tanggal_pembayaran_biaya,
            'id_pembelian' => $this->id_pembelian,
            'cara_bayar' => $this->cara_bayar,
            'id_kas_bank' => $this->id_kas_bank,
            'nominal' => $this->nominal,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
