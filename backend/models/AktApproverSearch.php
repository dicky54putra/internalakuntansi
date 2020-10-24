<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktApprover;

/**
 * AktApproverSearch represents the model behind the search form of `backend\models\AktApprover`.
 */
class AktApproverSearch extends AktApprover
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_approver', 'tingkat_approver'], 'integer'],
            [['id_login', 'id_jenis_approver'], 'safe'],
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
        $query = AktApprover::find();
        $query->joinWith("login");
        $query->joinWith("jenis_approver");
        $query->orderBy("id_jenis_approver ASC");

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
            'id_approver' => $this->id_approver,
            // 'id_login' => $this->id_login,
            // 'jenis_approver' => $this->jenis_approver,
            'tingkat_approver' => $this->tingkat_approver,
        ]);

        $query->andFilterWhere(['like', 'login.nama', $this->id_login])
            ->andFilterWhere(['like', 'akt_jenis_approver.nama_jenis_approver', $this->id_jenis_approver]);

        return $dataProvider;
    }
}
