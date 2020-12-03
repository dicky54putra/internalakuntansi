<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPembelianHartaTetap;

/**
 * AktPembelianHartaTetapSearch represents the model behind the search form of `backend\models\AktPembelianHartaTetap`.
 */
class AktPembelianHartaTetapSearch extends AktPembelianHartaTetap
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian_harta_tetap'], 'integer'],
            [['tanggal', 'keterangan', 'no_pembelian_harta_tetap', 'id_supplier', 'id_mata_uang', 'status'], 'safe'],
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
        $query = AktPembelianHartaTetap::find();
        $query->joinwith('akt_mitra_bisnis');
        $query->orderBy('id_pembelian_harta_tetap desc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!empty($this->tanggal)) {
            $query->andFilterWhere(["date_format(tanggal, '%d-%m-%Y')" => $this->tanggal]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian_harta_tetap' => $this->id_pembelian_harta_tetap,
            'no_pembelian_harta_tetap' => $this->no_pembelian_harta_tetap,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_supplier]);

        return $dataProvider;
    }

    public function searchPembayaranBiaya($params)
    {
        $query = AktPembelianHartaTetap::find()->joinWith('akt_mitra_bisnis')->where(['status' => '2'])->orderBy('id_pembelian_harta_tetap desc');

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

        if (!empty($this->tanggal)) {
            $query->andFilterWhere(["date_format(tanggal, '%d-%m-%Y')" => $this->tanggal]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pembelian_harta_tetap' => $this->id_pembelian_harta_tetap,
            'no_pembelian_harta_tetap' => $this->no_pembelian_harta_tetap,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_supplier]);

        return $dataProvider;
    }
}
