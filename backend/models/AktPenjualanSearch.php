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
            [['id_penjualan', 'pajak', 'jenis_bayar', 'jumlah_tempo', 'materai', 'status', 'diskon'], 'integer'],
            [['no_order_penjualan', 'uang_muka', 'total', 'ongkir', 'tanggal_order_penjualan', 'no_penjualan', 'tanggal_penjualan', 'no_faktur_penjualan', 'tanggal_faktur_penjualan', 'tanggal_tempo', 'id_customer', 'id_sales', 'id_mata_uang', 'no_spb', 'the_approver', 'the_approver_date', 'id_kas_bank', 'tanggal_estimasi'], 'safe'],
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
        $query = AktPenjualan::find()->where(['IS NOT', 'no_order_penjualan', null])->orderBy("id_penjualan DESC");
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

        if (!empty($this->tanggal_order_penjualan)) {
            $query->andFilterWhere(["date_format(tanggal_order_penjualan, '%d-%m-%Y')" => $this->tanggal_order_penjualan]);
        }

        // if (!is_null($this->tanggal_order_penjualan) && strpos($this->tanggal_order_penjualan, ' - ') !== false) {

        //     list($start_date, $end_date) = explode(' - ', $this->tanggal_order_penjualan);

        //     $query->andFilterWhere(['between', 'date(tanggal_order_penjualan)', $start_date, $end_date]);
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_penjualan' => $this->id_penjualan,
            'the_approver_date' => $this->the_approver_date,
        ]);

        $query->andFilterWhere(['like', 'no_order_penjualan', $this->no_order_penjualan])
            ->andFilterWhere(['like', 'no_penjualan', $this->no_penjualan])
            // ->andFilterWhere(['like', 'tanggal_order_penjualan', $this->tanggal_order_penjualan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_sales.nama_sales', $this->id_sales])
            ->andFilterWhere(['like', 'login.nama', $this->the_approver]);

        return $dataProvider;
    }

    public function searchPenjualan($params)
    {
        $query = AktPenjualan::find();
        $query->joinWith("customer");
        $query->joinWith("sales");
        $query->joinWith("mata_uang");
        $query->where(['>', 'akt_penjualan.status', 1])
            ->andWhere(['!=', 'akt_penjualan.status', 5])
            ->orderBy("id_penjualan DESC");

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

        if (!empty($this->tanggal_penjualan)) {
            $query->andFilterWhere(["date_format(tanggal_penjualan, '%d-%m-%Y')" => $this->tanggal_penjualan]);
        }

        if (!empty($this->tanggal_estimasi)) {
            $query->andFilterWhere(["date_format(tanggal_estimasi, '%d-%m-%Y')" => $this->tanggal_estimasi]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_penjualan' => $this->id_penjualan,
        ]);

        $query->andFilterWhere(['like', 'no_order_penjualan', $this->no_order_penjualan])
            ->andFilterWhere(['like', 'no_penjualan', $this->no_penjualan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_sales.nama_sales', $this->id_sales]);

        return $dataProvider;
    }

    public function searchPiutang($params)
    {
        $query = AktPenjualan::find();
        $query->joinWith("customer");
        $query->joinWith("sales");
        $query->joinWith("mata_uang");
        $query->where(['akt_penjualan.jenis_bayar' => 2, 'akt_penjualan.status' => 4]);
        $query->andWhere(['!=', 'akt_penjualan.total', 0]);

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

        if (!empty($this->tanggal_penjualan)) {
            $query->andFilterWhere(["date_format(tanggal_penjualan, '%d-%m-%Y')" => $this->tanggal_penjualan]);
        }

        if (!empty($this->tanggal_tempo)) {
            $query->andFilterWhere(["date_format(tanggal_tempo, '%d-%m-%Y')" => $this->tanggal_tempo]);
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'id_penjualan' => $this->id_penjualan,
            'jumlah_tempo' => $this->jumlah_tempo,
            'total' => $this->total,
        ]);

        $query->andFilterWhere(['like', 'no_penjualan', $this->no_penjualan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer]);

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

        if (!empty($this->tanggal_penjualan)) {
            $query->andFilterWhere(["date_format(tanggal_penjualan, '%d-%m-%Y')" => $this->tanggal_penjualan]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_penjualan' => $this->id_penjualan,
            'status' => $this->status,
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

        if (!empty($this->tanggal_penjualan)) {
            $query->andFilterWhere(["date_format(tanggal_penjualan, '%d-%m-%Y')" => $this->tanggal_penjualan]);
        }

        if (!empty($this->tanggal_faktur_penjualan)) {
            $query->andFilterWhere(["date_format(tanggal_faktur_penjualan, '%d-%m-%Y')" => $this->tanggal_faktur_penjualan]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_penjualan' => $this->id_penjualan,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_penjualan', $this->no_penjualan])
            // ->andFilterWhere(['like', 'tanggal_faktur_penjualan', $this->tanggal_faktur_penjualan])
            // ->andFilterWhere(['like', 'tanggal_penjualan', $this->tanggal_penjualan])
            ->andFilterWhere(['like', 'no_faktur_penjualan', $this->no_faktur_penjualan]);

        return $dataProvider;
    }
}
