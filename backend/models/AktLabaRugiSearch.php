<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktLabaRugi;

/**
 * AktLabaRugiSearch represents the model behind the search form of `backend\models\AktLabaRugi`.
 */
class AktLabaRugiSearch extends AktLabaRugi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_laba_rugi', 'periode', 'id_login'], 'integer'],
            [['tanggal'], 'safe'],
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
        $query = AktLabaRugi::find();

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
            'id_laba_rugi' => $this->id_laba_rugi,
            'tanggal' => $this->tanggal,
            'periode' => $this->periode,
            'id_login' => $this->id_login,
        ]);

        return $dataProvider;
    }
}
