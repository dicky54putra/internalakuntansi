<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktMerk;

/**
 * AktMerkSearch represents the model behind the search form of `backend\models\AktMerk`.
 */
class AktMerkSearch extends AktMerk
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_merk'], 'integer'],
            [['kode_merk', 'nama_merk'], 'safe'],
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
        $query = AktMerk::find();

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
            'id_merk' => $this->id_merk,
        ]);

        $query->andFilterWhere(['like', 'kode_merk', $this->kode_merk])
            ->andFilterWhere(['like', 'nama_merk', $this->nama_merk]);

        return $dataProvider;
    }
}
