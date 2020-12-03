<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPembelian;
use DateTime;

/**
 * AktPembelianSearch represents the model behind the search form of `backend\models\AktPembelian`.
 */
class AktPembelianSearch extends AktPembelian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian',  'status'], 'integer'],
            [['no_order_pembelian', 'no_pembelian', 'id_customer', 'tanggal_pembelian', "tanggal_order_pembelian", 'no_faktur_pembelian', 'tanggal_faktur_pembelian', 'tanggal_tempo', 'tanggal_estimasi', 'jatuh_tempo'], 'safe'],
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
        $query = AktPembelian::find();
        $query->joinWith('customer');
        $query->where(['IS NOT', 'no_order_pembelian', null]);
        $query->orderBy("id_pembelian desc");

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

        if (!empty($this->tanggal_order_pembelian)) {
            $query->andFilterWhere(["date_format(tanggal_order_pembelian, '%d-%m-%Y')" => $this->tanggal_order_pembelian]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian' => $this->id_pembelian,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian])
            ->andFilterWhere(['like', 'no_faktur_pembelian', $this->no_faktur_pembelian]);

        return $dataProvider;
    }

    public function searchPembelian($params)
    {
        // 
        $query = AktPembelian::find();
        $query->joinWith("customer");
        $query->joinWith("mata_uang");
        $query->joinWith("penagih");
        $query->where(['!=', 'akt_pembelian.status', 1]);
        $query->andWhere(['!=', 'akt_pembelian.status', 6]);
        $query->orderBy("id_pembelian desc");


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

        if (!empty($this->tanggal_pembelian)) {
            $query->andFilterWhere(["date_format(tanggal_pembelian, '%d-%m-%Y')" => $this->tanggal_pembelian]);
        }

        if (!empty($this->tanggal_estimasi)) {
            $query->andFilterWhere(["date_format(tanggal_estimasi, '%d-%m-%Y')" => $this->tanggal_estimasi]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian' => $this->id_pembelian,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer]);

        return $dataProvider;
    }

    public function searchPenerimaan($params)
    {
        $query = AktPembelian::find()->where(['=', 'akt_pembelian.status', 4])->orWhere(['=', 'akt_pembelian.status', 5]);
        $query->joinWith("customer");
        $query->joinWith("mata_uang");
        $query->joinWith("penagih");

        $query->orderBy("id_pembelian desc");

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
        if (!empty($this->tanggal_pembelian)) {
            $query->andFilterWhere(["date_format(tanggal_pembelian, '%d-%m-%Y')" => $this->tanggal_pembelian]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian' => $this->id_pembelian,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            // ->andFilterWhere(['like', 'tanggal_pembelian', $this->tanggal_pembelian])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian]);

        return $dataProvider;
    }

    public function searchHutang($params)
    {
        $query = AktPembelian::find();
        $query->joinWith("customer");
        $query->where(['!=', 'akt_pembelian.status', '1']);
        $query->andWhere(['!=', 'akt_pembelian.total', 0]);
        $query->orderBy("id_pembelian desc");

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

        if (!empty($this->tanggal_pembelian)) {
            $query->andFilterWhere(["date_format(tanggal_pembelian, '%d-%m-%Y')" => $this->tanggal_pembelian]);
        }

        if (!empty($this->tanggal_tempo)) {
            $query->andFilterWhere(["date_format(tanggal_tempo, '%d-%m-%Y')" => $this->tanggal_tempo]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian' => $this->id_pembelian,
            'jatuh_tempo' => $this->jatuh_tempo,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian])
            ->andFilterWhere(['like', 'no_faktur_pembelian', $this->no_faktur_pembelian]);

        return $dataProvider;
    }

    public function searchPembayaranBiaya($params)
    {
        $query = AktPembelian::find();
        $query->joinWith("customer");
        $query->joinWith("mata_uang");
        $query->joinWith("penagih");
        $query->where(['!=', 'akt_pembelian.status', '1']);
        $query->andWhere(['!=', 'akt_pembelian.total', 0]);
        $query->orderBy("id_pembelian desc");


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

        if (!empty($this->tanggal_faktur_pembelian)) {
            $query->andFilterWhere(["date_format(tanggal_faktur_pembelian, '%d-%m-%Y')" => $this->tanggal_faktur_pembelian]);
        }

        if (!empty($this->tanggal_pembelian)) {
            $query->andFilterWhere(["date_format(tanggal_pembelian, '%d-%m-%Y')" => $this->tanggal_pembelian]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian' => $this->id_pembelian,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian])
            ->andFilterWhere(['like', 'no_faktur_pembelian', $this->no_faktur_pembelian]);

        return $dataProvider;
    }

    protected function convertDateInput($date)
    {
        $date = new DateTime($date);
        // echo $date->format('d.m.Y'); // 31.07.2012
        return $date->format('Y-m-d'); // 31-07-2012
    }
}
