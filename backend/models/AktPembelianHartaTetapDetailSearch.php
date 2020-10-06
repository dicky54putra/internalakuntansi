<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPembelianHartaTetapDetail;

/**
 * AktPembelianHartaTetapSearch represents the model behind the search form of `backend\models\AktPembelianHartaTetap`.
 */
class AktPembelianHartaTetapDetailSearch extends AktPembelianHartaTetapDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian_harta_tetap', 'status'], 'integer'],
            [['kode_pembelian', 'qty', 'harga', 'diskon', 'nama_barang', 'no_pembelian_harta_tetap'], 'safe'],
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
        $query = AktPembelianHartaTetapDetail::find();
        $query->joinWith(['akt_pembelian_harta_tetap']);
        $query->where(['akt_pembelian_harta_tetap.status' => 2]);
        $query->orderBy('kode_pembelian desc');
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
            'kode_pembelian' => $this->kode_pembelian,
            'akt_pembelian_harta_tetap.no_pembelian_harta_tetap', $this->akt_pembelian_harta_tetap,
            'qty' => $this->qty,
            'nama_barang' => $this->nama_barang,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'nama_barang', $this->nama_barang])
            ->andFilterWhere(['like', 'akt_pembelian_harta_tetap.no_pembelian_harta_tetap', $this->akt_pembelian_harta_tetap])
            ->andFilterWhere(['like', 'kode_pembelian', $this->kode_pembelian]);

        return $dataProvider;
    }
}
