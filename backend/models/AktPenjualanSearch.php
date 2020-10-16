<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenjualan;

/**
 * AktPenjualanSearch represents the model behind the search form of `backend\models\AktPenjualan`.
 */
class AktPenjualanSearch extends AktPenjualan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan', 'ongkir', 'pajak', 'total', 'jenis_bayar', 'jumlah_tempo', 'materai', 'status', 'diskon', 'uang_muka'], 'integer'],
            [['no_order_penjualan', 'tanggal_order_penjualan', 'no_penjualan', 'tanggal_penjualan', 'no_faktur_penjualan', 'tanggal_faktur_penjualan', 'tanggal_tempo', 'id_customer', 'id_sales', 'id_mata_uang', 'no_spb', 'the_approver', 'the_approver_date', 'id_kas_bank', 'tanggal_estimasi'], 'safe'],
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
        $query = AktPenjualan::find()->where(['!=', 'no_order_penjualan', null])->orderBy("id_penjualan DESC");
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
            'id_penjualan' => $this->id_penjualan,
            'tanggal_order_penjualan' => $this->tanggal_order_penjualan,
            // 'id_customer' => $this->id_customer,
            // 'id_sales' => $this->id_sales,
            // 'id_mata_uang' => $this->id_mata_uang,
            'the_approver_date' => $this->the_approver_date,
            'tanggal_penjualan' => $this->tanggal_penjualan,
            'tanggal_faktur_penjualan' => $this->tanggal_faktur_penjualan,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jumlah_tempo' => $this->jumlah_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            'status' => $this->status,
            'diskon' => $this->diskon,
            'tanggal_estimasi' => $this->tanggal_estimasi,
        ]);

        $query->andFilterWhere(['like', 'no_order_penjualan', $this->no_order_penjualan])
            ->andFilterWhere(['like', 'no_penjualan', $this->no_penjualan])
            ->andFilterWhere(['like', 'no_faktur_penjualan', $this->no_faktur_penjualan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_sales.nama_sales', $this->id_sales])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang])
            ->andFilterWhere(['like', 'login.nama', $this->the_approver])
            ->andFilterWhere(['like', 'akt_kas_bank.keterangan', $this->id_kas_bank]);

        return $dataProvider;
    }

    public function searchPenjualan($params)
    {
        $query = AktPenjualan::find()->where(['>', 'akt_penjualan.status', 1])->andWhere(['!=', 'akt_penjualan.status', 5])->orderBy("id_penjualan DESC");
        $query->joinWith("customer");
        $query->joinWith("sales");
        $query->joinWith("mata_uang");

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
            'id_penjualan' => $this->id_penjualan,
            'tanggal_order_penjualan' => $this->tanggal_order_penjualan,
            // 'id_customer' => $this->id_customer,
            // 'id_sales' => $this->id_sales,
            // 'id_mata_uang' => $this->id_mata_uang,
            'tanggal_penjualan' => $this->tanggal_penjualan,
            'tanggal_faktur_penjualan' => $this->tanggal_faktur_penjualan,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jumlah_tempo' => $this->jumlah_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            'status' => $this->status,
            'diskon' => $this->diskon,
            'tanggal_estimasi' => $this->tanggal_estimasi,
        ]);

        $query->andFilterWhere(['like', 'no_order_penjualan', $this->no_order_penjualan])
            ->andFilterWhere(['like', 'no_penjualan', $this->no_penjualan])
            ->andFilterWhere(['like', 'no_faktur_penjualan', $this->no_faktur_penjualan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_sales.nama_sales', $this->id_sales])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang]);

        return $dataProvider;
    }

    public function searchPiutang($params)
    {
        $query = AktPenjualan::find()->where(['akt_penjualan.jenis_bayar' => 2, 'akt_penjualan.status' => 4]);
        $query->joinWith("customer");
        $query->joinWith("sales");
        $query->joinWith("mata_uang");

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
            'id_penjualan' => $this->id_penjualan,
            'tanggal_order_penjualan' => $this->tanggal_order_penjualan,
            // 'id_customer' => $this->id_customer,
            // 'id_sales' => $this->id_sales,
            // 'id_mata_uang' => $this->id_mata_uang,
            'tanggal_penjualan' => $this->tanggal_penjualan,
            'tanggal_faktur_penjualan' => $this->tanggal_faktur_penjualan,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jumlah_tempo' => $this->jumlah_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            'status' => $this->status,
            'diskon' => $this->diskon,
            'tanggal_estimasi' => $this->tanggal_estimasi,
        ]);

        $query->andFilterWhere(['like', 'no_order_penjualan', $this->no_order_penjualan])
            ->andFilterWhere(['like', 'no_penjualan', $this->no_penjualan])
            ->andFilterWhere(['like', 'no_faktur_penjualan', $this->no_faktur_penjualan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_sales.nama_sales', $this->id_sales])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang]);

        return $dataProvider;
    }

    public function searchPengiriman($params)
    {
        $query = AktPenjualan::find()->where(['>', 'akt_penjualan.status', 2])->andWhere(['!=', 'akt_penjualan.status', 5])->orderBy("id_penjualan DESC");
        $query->joinWith("customer");
        $query->joinWith("sales");
        $query->joinWith("mata_uang");

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
            'id_penjualan' => $this->id_penjualan,
            'tanggal_order_penjualan' => $this->tanggal_order_penjualan,
            // 'id_customer' => $this->id_customer,
            // 'id_sales' => $this->id_sales,
            // 'id_mata_uang' => $this->id_mata_uang,
            'tanggal_penjualan' => $this->tanggal_penjualan,
            'tanggal_faktur_penjualan' => $this->tanggal_faktur_penjualan,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jumlah_tempo' => $this->jumlah_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            'status' => $this->status,
            'diskon' => $this->diskon,
            'tanggal_estimasi' => $this->tanggal_estimasi,
        ]);

        $query->andFilterWhere(['like', 'no_order_penjualan', $this->no_order_penjualan])
            ->andFilterWhere(['like', 'no_penjualan', $this->no_penjualan])
            ->andFilterWhere(['like', 'no_faktur_penjualan', $this->no_faktur_penjualan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_sales.nama_sales', $this->id_sales])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang]);

        return $dataProvider;
    }

    public function searchPenerimaanPembayaran($params)
    {
        $query = AktPenjualan::find()->where(['!=', 'akt_penjualan.status', 1]);
        $query->joinWith("customer");
        $query->joinWith("sales");
        $query->joinWith("mata_uang");
        $query->orderBy("id_penjualan DESC");

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
            'id_penjualan' => $this->id_penjualan,
            'tanggal_order_penjualan' => $this->tanggal_order_penjualan,
            // 'id_customer' => $this->id_customer,
            // 'id_sales' => $this->id_sales,
            // 'id_mata_uang' => $this->id_mata_uang,
            'tanggal_penjualan' => $this->tanggal_penjualan,
            'tanggal_faktur_penjualan' => $this->tanggal_faktur_penjualan,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jumlah_tempo' => $this->jumlah_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            'status' => $this->status,
            'diskon' => $this->diskon,
            'tanggal_estimasi' => $this->tanggal_estimasi,
        ]);

        $query->andFilterWhere(['like', 'no_order_penjualan', $this->no_order_penjualan])
            ->andFilterWhere(['like', 'no_penjualan', $this->no_penjualan])
            ->andFilterWhere(['like', 'no_faktur_penjualan', $this->no_faktur_penjualan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_sales.nama_sales', $this->id_sales])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang]);

        return $dataProvider;
    }
}
