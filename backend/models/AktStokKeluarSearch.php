<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktStokKeluar;

/**
 * AktStokKeluarSearch represents the model behind the search form of `backend\models\AktStokKeluar`.
 */
class AktStokKeluarSearch extends AktStokKeluar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_keluar', 'tipe'], 'integer'],
            [['nomor_transaksi', 'tanggal_keluar', 'keterangan'], 'safe'],
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
        $query = AktStokKeluar::find();

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

        if (!empty($this->tanggal_keluar)) {
            $query->andFilterWhere(["date_format(tanggal_keluar, '%d-%m-%Y')" => $this->tanggal_keluar]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_stok_keluar' => $this->id_stok_keluar,
            'tipe' => $this->tipe,
            // 'id_akun_persediaan' => $this->id_akun_persediaan,
        ]);

        $query->andFilterWhere(['like', 'nomor_transaksi', $this->nomor_transaksi])
            // ->andFilterWhere(['like', 'tanggal_keluar', $this->tanggal_keluar])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
