<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenerimaanPembayaranHartaTetap;

/**
 * AktPenerimaanPembayaranHartaTetapSearch represents the model behind the search form of `backend\models\AktPenerimaanPembayaranHartaTetap`.
 */
class AktPenerimaanPembayaranHartaTetapSearch extends AktPenerimaanPembayaranHartaTetap
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penerimaan_pembayaran_harta_tetap', 'id_penjualan_harta_tetap', 'cara_bayar', 'id_kas_bank'], 'integer'],
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
        $query = AktPenerimaanPembayaranHartaTetap::find();

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
            'id_penerimaan_pembayaran_harta_tetap' => $this->id_penerimaan_pembayaran_harta_tetap,
            'tanggal_penerimaan_pembayaran' => $this->tanggal_penerimaan_pembayaran,
            'id_penjualan_harta_tetap' => $this->id_penjualan_harta_tetap,
            'cara_bayar' => $this->cara_bayar,
            'id_kas_bank' => $this->id_kas_bank,
            'nominal' => $this->nominal,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
