<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktKelompokHartaTetap;

/**
 * AktKelompokHartaTetapSearch represents the model behind the search form of `backend\models\AktKelompokHartaTetap`.
 */
class AktKelompokHartaTetapSearch extends AktKelompokHartaTetap
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kelompok_harta_tetap', 'umur_ekonomis', 'metode_depresiasi', 'id_akun_harta', 'id_akun_akumulasi', 'id_akun_depresiasi'], 'integer'],
            [['kode', 'nama', 'keterangan'], 'safe'],
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
        $query = AktKelompokHartaTetap::find();

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
            'id_kelompok_harta_tetap' => $this->id_kelompok_harta_tetap,
            'umur_ekonomis' => $this->umur_ekonomis,
            'metode_depresiasi' => $this->metode_depresiasi,
            'id_akun_harta' => $this->id_akun_harta,
            'id_akun_akumulasi' => $this->id_akun_akumulasi,
            'id_akun_depresiasi' => $this->id_akun_depresiasi,
        ]);

        $query->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
