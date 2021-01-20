<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktKota;

/**
 * AktKotaSearch represents the model behind the search form of `backend\models\AktKota`.
 */
class AktKotaSearch extends AktKota
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kota'], 'integer'],
            [['kode_kota', 'nama_kota'], 'safe'],
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
        $query = AktKota::find();

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
            'id_kota' => $this->id_kota,
        ]);

        $query->andFilterWhere(['like', 'kode_kota', $this->kode_kota])
            ->andFilterWhere(['like', 'nama_kota', $this->nama_kota]);

        return $dataProvider;
    }
}
