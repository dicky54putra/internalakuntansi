<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenyesuaianStok;

/**
 * AktPenyesuaianStokSearch represents the model behind the search form of `backend\models\AktPenyesuaianStok`.
 */
class AktPenyesuaianStokSearch extends AktPenyesuaianStok
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penyesuaian_stok', 'tipe_penyesuaian'], 'integer'],
            [['no_transaksi', 'tanggal_penyesuaian', 'keterangan_penyesuaian', 'status'], 'safe'],
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
        $query = AktPenyesuaianStok::find();

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
            'id_penyesuaian_stok' => $this->id_penyesuaian_stok,
            'tanggal_penyesuaian' => $this->tanggal_penyesuaian,
            'tipe_penyesuaian' => $this->tipe_penyesuaian,
        ]);

        $query->andFilterWhere(['like', 'no_transaksi', $this->no_transaksi])
            ->andFilterWhere(['like', 'keterangan_penyesuaian', $this->keterangan_penyesuaian]);

        return $dataProvider;
    }
}
