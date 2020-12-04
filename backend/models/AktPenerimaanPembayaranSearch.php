<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenerimaanPembayaran;

/**
 * AktPenerimaanPembayaranSearch represents the model behind the search form of `backend\models\AktPenerimaanPembayaran`.
 */
class AktPenerimaanPembayaranSearch extends AktPenerimaanPembayaran
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penerimaan_pembayaran_penjualan', 'id_penjualan', 'cara_bayar', 'id_kas_bank'], 'integer'],
            [['tanggal_penerimaan_pembayaran', 'keterangan', 'nominal'], 'safe'],
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
        $query = AktPenerimaanPembayaran::find();

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
            'id_penerimaan_pembayaran_penjualan' => $this->id_penerimaan_pembayaran_penjualan,
            'tanggal_penerimaan_pembayaran' => $this->tanggal_penerimaan_pembayaran,
            'id_penjualan' => $this->id_penjualan,
            'cara_bayar' => $this->cara_bayar,
            'id_kas_bank' => $this->id_kas_bank,
            'nominal' => $this->nominal,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
