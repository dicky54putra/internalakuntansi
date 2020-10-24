<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktCekGiro;

/**
 * AktCekGiroSearch represents the model behind the search form of `backend\models\AktCekGiro`.
 */
class AktCekGiroSearch extends AktCekGiro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cek_giro', 'tanggal_effektif', 'tipe', 'in_out', 'id_bank_asal', 'id_mata_uang', 'id_penerbit', 'id_penerima'], 'integer'],
            [['no_transaksi', 'no_cek_giro', 'tanggal_terbit', 'cabang_bank', 'tanggal_kliring', 'bank_kliring'], 'safe'],
            [['jumlah'], 'number'],
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
        $query = AktCekGiro::find();

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
            'id_cek_giro' => $this->id_cek_giro,
            'tanggal_terbit' => $this->tanggal_terbit,
            'tanggal_effektif' => $this->tanggal_effektif,
            'tipe' => $this->tipe,
            'in_out' => $this->in_out,
            'id_bank_asal' => $this->id_bank_asal,
            'id_mata_uang' => $this->id_mata_uang,
            'jumlah' => $this->jumlah,
            'tanggal_kliring' => $this->tanggal_kliring,
            'id_penerbit' => $this->id_penerbit,
            'id_penerima' => $this->id_penerima,
        ]);

        $query->andFilterWhere(['like', 'no_transaksi', $this->no_transaksi])
            ->andFilterWhere(['like', 'no_cek_giro', $this->no_cek_giro])
            ->andFilterWhere(['like', 'cabang_bank', $this->cabang_bank])
            ->andFilterWhere(['like', 'bank_kliring', $this->bank_kliring]);

        return $dataProvider;
    }
}
