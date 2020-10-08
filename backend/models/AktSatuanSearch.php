<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktSatuan;

/**
 * AktSatuanSearch represents the model behind the search form of `backend\models\AktSatuan`.
 */
class AktSatuanSearch extends AktSatuan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_satuan'], 'integer'],
            [['nama_satuan'], 'safe'],
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
        $query = AktSatuan::find();

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
            'id_satuan' => $this->id_satuan,
        ]);

        $query->andFilterWhere(['like', 'nama_satuan', $this->nama_satuan]);

        return $dataProvider;
    }
}
