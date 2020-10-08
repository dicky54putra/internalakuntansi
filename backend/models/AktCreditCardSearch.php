<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktCreditCard;

/**
 * AktCreditCardSearch represents the model behind the search form of `backend\models\AktCreditCard`.
 */
class AktCreditCardSearch extends AktCreditCard
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cc'], 'integer'],
            [['nama_cc', 'kode_cc'], 'safe'],
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
        $query = AktCreditCard::find();

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
            'id_cc' => $this->id_cc,
        ]);

        $query->andFilterWhere(['like', 'nama_cc', $this->nama_cc]);
        $query->andFilterWhere(['like', 'kode_cc', $this->kode_cc]);

        return $dataProvider;
    }
}
