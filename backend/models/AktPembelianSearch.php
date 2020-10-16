<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPembelian;

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
            [['id_pembelian', 'id_customer', 'id_mata_uang', 'ongkir', 'diskon', 'pajak', 'total', 'jenis_bayar', 'jatuh_tempo', 'materai', 'id_penagih', 'status'], 'integer'],
            [['no_order_pembelian', 'no_pembelian', 'tanggal_pembelian', 'no_faktur_pembelian', 'tanggal_faktur_pembelian', 'tanggal_tempo', 'tanggal_estimasi'], 'safe'],
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
        $query->where(['!=', 'no_order_pembelian', 'null']);
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
            'id_customer' => $this->id_customer,
            'id_mata_uang' => $this->id_mata_uang,
            'tanggal_pembelian' => $this->tanggal_pembelian,
            'tanggal_estimasi' => $this->tanggal_estimasi,
            'tanggal_faktur_pembelian' => $this->tanggal_faktur_pembelian,
            'ongkir' => $this->ongkir,
            'diskon' => $this->diskon,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jatuh_tempo' => $this->jatuh_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            'id_penagih' => $this->id_penagih,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian])
            ->andFilterWhere(['like', 'tanggal_estimasi', $this->tanggal_estimasi])
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian' => $this->id_pembelian,
            'tanggal_order_pembelian' => $this->tanggal_order_pembelian,
            // 'id_customer' => $this->id_customer,
            // 'id_mata_uang' => $this->id_mata_uang,
            'tanggal_pembelian' => $this->tanggal_pembelian,
            'tanggal_faktur_pembelian' => $this->tanggal_faktur_pembelian,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jatuh_tempo' => $this->jatuh_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            // 'id_penagih' => $this->id_penagih,
            'status' => $this->status,
            'diskon' => $this->diskon,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian])
            ->andFilterWhere(['like', 'no_faktur_pembelian', $this->no_faktur_pembelian])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang])
            ->andFilterWhere(['like', 'penagih.nama_mitra_bisnis', $this->id_penagih]);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian' => $this->id_pembelian,
            'tanggal_order_pembelian' => $this->tanggal_order_pembelian,
            // 'id_customer' => $this->id_customer,
            // 'id_mata_uang' => $this->id_mata_uang,
            'tanggal_pembelian' => $this->tanggal_pembelian,
            'tanggal_faktur_pembelian' => $this->tanggal_faktur_pembelian,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jatuh_tempo' => $this->jatuh_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            // 'id_penagih' => $this->id_penagih,
            'status' => $this->status,
            'diskon' => $this->diskon,
            // 'tanggal_penerimaan' => $this->tanggal_penerimaan,
            'tanggal_penerimaan' => $this->tanggal_penerimaan,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian])
            ->andFilterWhere(['like', 'no_faktur_pembelian', $this->no_faktur_pembelian])
            // ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang])
            ->andFilterWhere(['like', 'penagih.nama_mitra_bisnis', $this->id_penagih])
            ->andFilterWhere(['like', 'no_penerimaan', $this->no_penerimaan])
            ->andFilterWhere(['like', 'pengantar', $this->pengantar])
            ->andFilterWhere(['like', 'penerima', $this->penerima])
            ->andFilterWhere(['like', 'keterangan_penerimaan', $this->keterangan_penerimaan])
            // ->andFilterWhere(['like', 'akt_mitra_bisnis_alamat.keterangan_alamat', $this->id_mitra_bisnis_alamat])
            ->andFilterWhere(['like', 'no_spb', $this->no_spb]);

        return $dataProvider;
    }

    public function searchHutang($params)
    {
        $query = AktPembelian::find()->where(['jenis_bayar' => 2, 'status' => 4]);

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
            'id_customer' => $this->id_customer,
            'id_mata_uang' => $this->id_mata_uang,
            'tanggal_pembelian' => $this->tanggal_pembelian,
            'tanggal_faktur_pembelian' => $this->tanggal_faktur_pembelian,
            'ongkir' => $this->ongkir,
            'diskon' => $this->diskon,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jatuh_tempo' => $this->jatuh_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            'id_penagih' => $this->id_penagih,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian])
            ->andFilterWhere(['like', 'no_faktur_pembelian', $this->no_faktur_pembelian]);

        return $dataProvider;
    }

    public function searchPembayaranBiaya($params)
    {
        $query = AktPembelian::find()
            ->where(['!=', 'akt_pembelian.status', '1']);
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian' => $this->id_pembelian,
            'tanggal_order_pembelian' => $this->tanggal_order_pembelian,
            // 'id_customer' => $this->id_customer,
            // 'id_mata_uang' => $this->id_mata_uang,
            'tanggal_pembelian' => $this->tanggal_pembelian,
            'tanggal_faktur_pembelian' => $this->tanggal_faktur_pembelian,
            'ongkir' => $this->ongkir,
            'pajak' => $this->pajak,
            'total' => $this->total,
            'jenis_bayar' => $this->jenis_bayar,
            'jatuh_tempo' => $this->jatuh_tempo,
            'tanggal_tempo' => $this->tanggal_tempo,
            'materai' => $this->materai,
            // 'id_penagih' => $this->id_penagih,
            'status' => $this->status,
            'diskon' => $this->diskon,
        ]);

        $query->andFilterWhere(['like', 'no_order_pembelian', $this->no_order_pembelian])
            ->andFilterWhere(['like', 'no_pembelian', $this->no_pembelian])
            ->andFilterWhere(['like', 'no_faktur_pembelian', $this->no_faktur_pembelian])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang])
            ->andFilterWhere(['like', 'penagih.nama_mitra_bisnis', $this->id_penagih]);

        return $dataProvider;
    }
}
