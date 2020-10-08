<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktMitraBisnisBankPajak;

/**
 * AktMitraBisnisBankPajakSearch represents the model behind the search form of `backend\models\AktMitraBisnisBankPajak`.
 */
class AktMitraBisnisBankPajakSearch extends AktMitraBisnisBankPajak
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mitra_bisnis_bank_pajak', 'id_mitra_bisnis', 'pembelian_pajak', 'penjualan_pajak'], 'integer'],
            [['nama_bank', 'no_rekening', 'atas_nama', 'npwp', 'pkp', 'tanggal_pkp', 'no_nik', 'atas_nama_nik'], 'safe'],
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
        $query = AktMitraBisnisBankPajak::find();

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
            'id_mitra_bisnis_bank_pajak' => $this->id_mitra_bisnis_bank_pajak,
            'id_mitra_bisnis' => $this->id_mitra_bisnis,
            'tanggal_pkp' => $this->tanggal_pkp,
            'pembelian_pajak' => $this->pembelian_pajak,
            'penjualan_pajak' => $this->penjualan_pajak,
        ]);

        $query->andFilterWhere(['like', 'nama_bank', $this->nama_bank])
            ->andFilterWhere(['like', 'no_rekening', $this->no_rekening])
            ->andFilterWhere(['like', 'atas_nama', $this->atas_nama])
            ->andFilterWhere(['like', 'npwp', $this->npwp])
            ->andFilterWhere(['like', 'pkp', $this->pkp])
            ->andFilterWhere(['like', 'no_nik', $this->no_nik])
            ->andFilterWhere(['like', 'atas_nama_nik', $this->atas_nama_nik]);

        return $dataProvider;
    }
}
