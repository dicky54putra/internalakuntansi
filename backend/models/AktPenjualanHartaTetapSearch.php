<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenjualanHartaTetap;

/**
 * AktPenjualanHartaTetapSearch represents the model behind the search form of `backend\models\AktPenjualanHartaTetap`.
 */
class AktPenjualanHartaTetapSearch extends AktPenjualanHartaTetap
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan_harta_tetap', 'ongkir', 'pajak', 'uang_muka', 'total', 'diskon', 'jenis_bayar', 'jumlah_tempo', 'materai', 'status'], 'integer'],
            [['no_penjualan_harta_tetap', 'tanggal_penjualan_harta_tetap', 'the_approver_date', 'no_faktur_penjualan_harta_tetap', 'tanggal_faktur_penjualan_harta_tetap', 'tanggal_tempo', 'id_customer', 'id_sales', 'id_mata_uang', 'the_approver', 'id_kas_bank'], 'safe'],
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
        $query = AktPenjualanHartaTetap::find();
        $query->joinWith("customer");
        $query->joinWith("sales");
        $query->joinWith("mata_uang");
        $query->joinWith("approver");
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
            'id_penjualan_harta_tetap' => $this->id_penjualan_harta_tetap,
            'tanggal_penjualan_harta_tetap' => $this->tanggal_penjualan_harta_tetap,
            // 'id_customer' => $this->id_customer,
            // 'id_sales' => $this->id_sales,
            // 'id_mata_uang' => $this->id_mata_uang,
            // 'the_approver' => $this->the_approver,
            'the_approver_date' => $this->the_approver_date,
            'tanggal_faktur_penjualan_harta_tetap' => $this->tanggal_faktur_penjualan_harta_tetap,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'uang_muka' => $this->uang_muka,
            // 'id_kas_bank' => $this->id_kas_bank,
            'total' => $this->total,
            'diskon' => $this->diskon,
            'jenis_bayar' => $this->jenis_bayar,
            'jumlah_tempo' => $this->jumlah_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_penjualan_harta_tetap', $this->no_penjualan_harta_tetap])
            ->andFilterWhere(['like', 'no_faktur_penjualan_harta_tetap', $this->no_faktur_penjualan_harta_tetap])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_sales.nama_sales', $this->id_sales])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang])
            ->andFilterWhere(['like', 'login.nama', $this->the_approver])
            ->andFilterWhere(['like', 'akt_kas_bank.keterangan', $this->id_kas_bank]);

        return $dataProvider;
    }

    public function searchPenerimaanPembayaran($params)
    {
        $query = AktPenjualanHartaTetap::find();
        $query->where(['status' => '2']);
        $query->joinWith("customer");
        $query->joinWith("sales");
        $query->joinWith("mata_uang");
        $query->joinWith("approver");
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
            'id_penjualan_harta_tetap' => $this->id_penjualan_harta_tetap,
            'tanggal_penjualan_harta_tetap' => $this->tanggal_penjualan_harta_tetap,
            // 'id_customer' => $this->id_customer,
            // 'id_sales' => $this->id_sales,
            // 'id_mata_uang' => $this->id_mata_uang,
            // 'the_approver' => $this->the_approver,
            'the_approver_date' => $this->the_approver_date,
            'tanggal_faktur_penjualan_harta_tetap' => $this->tanggal_faktur_penjualan_harta_tetap,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'uang_muka' => $this->uang_muka,
            // 'id_kas_bank' => $this->id_kas_bank,
            'total' => $this->total,
            'diskon' => $this->diskon,
            'jenis_bayar' => $this->jenis_bayar,
            'jumlah_tempo' => $this->jumlah_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_penjualan_harta_tetap', $this->no_penjualan_harta_tetap])
            ->andFilterWhere(['like', 'no_faktur_penjualan_harta_tetap', $this->no_faktur_penjualan_harta_tetap])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_sales.nama_sales', $this->id_sales])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang])
            ->andFilterWhere(['like', 'login.nama', $this->the_approver])
            ->andFilterWhere(['like', 'akt_kas_bank.keterangan', $this->id_kas_bank]);

        return $dataProvider;
    }
}
