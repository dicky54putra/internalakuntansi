<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktProyek;

/**
 * AktProyekSearch represents the model behind the search form of `backend\models\AktProyek`.
 */
class AktProyekSearch extends AktProyek
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_proyek', 'id_pegawai', 'id_mitra_bisnis', 'status_aktif'], 'integer'],
            [['kode_proyek', 'nama_proyek'], 'safe'],
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
        $query = AktProyek::find();

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
            'id_proyek' => $this->id_proyek,
            'id_pegawai' => $this->id_pegawai,
            'id_mitra_bisnis' => $this->id_mitra_bisnis,
            'status_aktif' => $this->status_aktif,
        ]);

        $query->andFilterWhere(['like', 'kode_proyek', $this->kode_proyek])
            ->andFilterWhere(['like', 'nama_proyek', $this->nama_proyek]);

        return $dataProvider;
    }
}
