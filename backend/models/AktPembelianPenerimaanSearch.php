<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPembelianPenerimaan;

/**
 * AktPembelianPenerimaanSearch represents the model behind the search form of `backend\models\AktPembelianPenerimaan`.
 */
class AktPembelianPenerimaanSearch extends AktPembelianPenerimaan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian_penerimaan', 'id_pembelian'], 'integer'],
            [['no_penerimaan', 'tanggal_penerimaan', 'penerima', 'foto_resi', 'pengantar', 'keterangan_pengantar'], 'safe'],
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
        $query = AktPembelianPenerimaan::find();
        $query->joinWith("mitra_bisnis_alamat");

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
            'id_pembelian_penerimaan' => $this->id_pembelian_penerimaan,
            'tanggal_penerimaan' => $this->tanggal_penerimaan,
            'id_pembelian' => $this->id_pembelian,
        ]);

        $query->andFilterWhere(['like', 'no_penerimaan', $this->no_penerimaan])
            ->andFilterWhere(['like', 'penerima', $this->penerima])
            ->andFilterWhere(['like', 'foto_resi', $this->foto_resi])
            ->andFilterWhere(['like', 'pengantar', $this->pengantar])
            ->andFilterWhere(['like', 'keterangan_pengantar', $this->keterangan_pengantar]);

        return $dataProvider;
    }
}
