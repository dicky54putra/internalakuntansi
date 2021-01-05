<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktItemTipe;

/**
 * AktItemTipeSearch represents the model behind the search form of `backend\models\AktItemTipe`.
 */
class AktItemTipeSearch extends AktItemTipe
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipe_item'], 'integer'],
            [['nama_tipe_item'], 'safe'],
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
        $query = AktItemTipe::find();

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
            'id_tipe_item' => $this->id_tipe_item,
        ]);

        $query->andFilterWhere(['like', 'nama_tipe_item', $this->nama_tipe_item]);

        return $dataProvider;
    }
}
