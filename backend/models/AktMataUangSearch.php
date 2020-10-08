<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktMataUang;

/**
 * AktMataUangSearch represents the model behind the search form of `backend\models\AktMataUang`.
 */
class AktMataUangSearch extends AktMataUang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mata_uang', 'status_default'], 'integer'],
            [['mata_uang', 'simbol', 'kurs', 'fiskal', 'rate_type', 'kode_mata_uang'], 'safe'],
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
        $query = AktMataUang::find();

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
            'id_mata_uang' => $this->id_mata_uang,
            'status_default' => $this->status_default,
        ]);

        $query->andFilterWhere(['like', 'mata_uang', $this->mata_uang])
            ->andFilterWhere(['like', 'simbol', $this->simbol])
            ->andFilterWhere(['like', 'kurs', $this->kurs])
            ->andFilterWhere(['like', 'kode_mata_uang', $this->kode_mata_uang])

            ->andFilterWhere(['like', 'fiskal', $this->fiskal])
            ->andFilterWhere(['like', 'rate_type', $this->rate_type]);

        return $dataProvider;
    }
}
