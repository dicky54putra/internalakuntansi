<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPermintaanBarang;

/**
 * AktPermintaanBarangSearch represents the model behind the search form of `backend\models\AktPermintaanBarang`.
 */
class AktPermintaanBarangSearch extends AktPermintaanBarang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_permintaan_barang', 'status_aktif'], 'integer'],
            [['nomor_permintaan', 'tanggal_permintaan','id_pegawai'], 'safe'],
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
        $query = AktPermintaanBarang::find();
        $query->joinWith('pegawai')->orderBy(['nomor_permintaan'=>SORT_DESC]);

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
            'id_permintaan_barang' => $this->id_permintaan_barang,
            'tanggal_permintaan' => $this->tanggal_permintaan,
            'status_aktif' => $this->status_aktif,
        ]);

        $query->andFilterWhere(['like', 'nomor_permintaan', $this->nomor_permintaan])
        ->andFilterWhere(['like', 'akt_pegawai.nama_pegawai', $this->id_pegawai]);

        return $dataProvider;
    }
}
