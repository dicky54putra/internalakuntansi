<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktBomDetailBb;

/**
 * AktBomDetailBbSearch represents the model behind the search form of `backend\models\AktBomDetailBb`.
 */
class AktBomDetailBbSearch extends AktBomDetailBb
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_bom_detail_bb', 'id_bom', 'id_item', 'qty'], 'integer'],
            [['harga'], 'number'],
            [['keterangan'], 'safe'],
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
        $query = AktBomDetailBb::find();

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
            'id_bom_detail_bb' => $this->id_bom_detail_bb,
            'id_bom' => $this->id_bom,
            'id_item' => $this->id_item,
            'qty' => $this->qty,
            'harga' => $this->harga,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
