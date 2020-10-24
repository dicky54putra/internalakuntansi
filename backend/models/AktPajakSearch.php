<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPajak;

/**
 * AktPajakSearch represents the model behind the search form of `backend\models\AktPajak`.
 */
class AktPajakSearch extends AktPajak
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pajak', 'id_akun_pembelian', 'id_akun_penjualan'], 'integer'],
            [['kode_pajak','nama_pajak', 'presentasi_npwp', 'presentasi_non_npwp'], 'safe'],
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
        $query = AktPajak::find();

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
            'id_pajak' => $this->id_pajak,
            'id_akun_pembelian' => $this->id_akun_pembelian,
            'id_akun_penjualan' => $this->id_akun_penjualan,
        ]);

        $query->andFilterWhere(['like', 'nama_pajak', $this->nama_pajak])
        ->andFilterWhere(['like', 'kode_pajak', $this->kode_pajak])
            ->andFilterWhere(['like', 'presentasi_npwp', $this->presentasi_npwp])
            ->andFilterWhere(['like', 'presentasi_non_npwp', $this->presentasi_non_npwp]);

        return $dataProvider;
    }
}
