<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktStokMasuk;

/**
 * AktStokMasukSearch represents the model behind the search form of `backend\models\AktStokMasuk`.
 */
class AktStokMasukSearch extends AktStokMasuk
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_masuk', 'tipe'], 'integer'],
            [['nomor_transaksi', 'tanggal_masuk', 'keterangan'], 'safe'],
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
        $query = AktStokMasuk::find();

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
            'id_stok_masuk' => $this->id_stok_masuk,
            'tanggal_masuk' => $this->tanggal_masuk,
            'tipe' => $this->tipe,
            // 'id_akun_persediaan' => $this->id_akun_persediaan,
        ]);

        $query->andFilterWhere(['like', 'nomor_transaksi', $this->nomor_transaksi])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
