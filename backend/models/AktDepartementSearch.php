<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktDepartement;

/**
 * AktDepartementSearch represents the model behind the search form of `backend\models\AktDepartement`.
 */
class AktDepartementSearch extends AktDepartement
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_departement', 'status_aktif'], 'integer'],
            [['kode_departement', 'nama_departement', 'keterangan'], 'safe'],
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
        $query = AktDepartement::find();

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
            'id_departement' => $this->id_departement,
            'status_aktif' => $this->status_aktif,
        ]);

        $query->andFilterWhere(['like', 'kode_departement', $this->kode_departement])
            ->andFilterWhere(['like', 'nama_departement', $this->nama_departement])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
