<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktJenisApprover;

/**
 * AktJenisApproverSearch represents the model behind the search form of `backend\models\AktJenisApprover`.
 */
class AktJenisApproverSearch extends AktJenisApprover
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jenis_approver'], 'integer'],
            [['nama_jenis_approver'], 'safe'],
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
        $query = AktJenisApprover::find();

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
            'id_jenis_approver' => $this->id_jenis_approver,
        ]);

        $query->andFilterWhere(['like', 'nama_jenis_approver', $this->nama_jenis_approver]);

        return $dataProvider;
    }
}
