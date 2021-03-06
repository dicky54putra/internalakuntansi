<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenyesuaianKas;

/**
 * AktPenyesuaianKasSearch represents the model behind the search form of `backend\models\AktPenyesuaianKas`.
 */
class AktPenyesuaianKasSearch extends AktPenyesuaianKas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penyesuaian_kas', 'tipe', 'id_kas_bank', 'id_mata_uang'], 'integer'],
            [['no_transaksi', 'tanggal', 'no_referensi', 'keterangan', 'id_akun'], 'safe'],
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
        $query = AktPenyesuaianKas::find();
        $query->joinWith(['akun']);
        $query->joinWith(['mata_uang']);
        $query->joinWith(['kas_bank']);
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
            'id_penyesuaian_kas' => $this->id_penyesuaian_kas,
            'jumlah' => $this->jumlah,
        ]);

        $query->andFilterWhere(['like', 'no_transaksi', $this->no_transaksi])
            ->andFilterWhere(['like', 'akt_akun.nama_akun', $this->id_akun])
            ->andFilterWhere(['like', 'tipe', $this->tipe])
            ->andFilterWhere(['like', 'no_referensi', $this->no_referensi])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
