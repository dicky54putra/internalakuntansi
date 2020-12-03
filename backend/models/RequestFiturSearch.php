<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\RequestFitur;

/**
 * RequestFiturSearch represents the model behind the search form of `backend\models\RequestFitur`.
 */
class RequestFiturSearch extends RequestFitur
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_request_fitur'], 'integer'],
            [['tanggal', 'keterangan', 'status', 'id_login'], 'safe'],
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
        $query = RequestFitur::find();
        $query->joinWith(['login']);
        $query->orderBy(['status'=> SORT_ASC, 'tanggal'=> SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['id_request_fitur'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_request_fitur' => $this->id_request_fitur,
            'status' => $this->status,
            // 'id_login' => $this->id_login,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan])
			->andFilterWhere(['like', 'date_format(tanggal, "%d-%m-%Y")', $this->tanggal])
              ->andFilterWhere(['like', 'login.nama', $this->id_login]);

        return $dataProvider;
    }
}
