<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktLevelHarga;

/**
 * AktLevelHargaSearch represents the model behind the search form of `backend\models\AktLevelHarga`.
 */
class AktLevelHargaSearch extends AktLevelHarga
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_level_harga'], 'integer'],
            [['kode_level_harga', 'keterangan'], 'safe'],
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
        $query = AktLevelHarga::find();

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
            'id_level_harga' => $this->id_level_harga,
        ]);

        $query->andFilterWhere(['like', 'kode_level_harga', $this->kode_level_harga])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
