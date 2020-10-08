<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktGudang;

/**
 * AktGudangSearch represents the model behind the search form of `backend\models\AktGudang`.
 */
class AktGudangSearch extends AktGudang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_gudang', 'status_aktif_gudang'], 'integer'],
            [['kode_gudang', 'nama_gudang'], 'safe'],
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
        $query = AktGudang::find();

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
            'id_gudang' => $this->id_gudang,
            'status_aktif_gudang' => $this->status_aktif_gudang,
        ]);

        $query->andFilterWhere(['like', 'kode_gudang', $this->kode_gudang])
            ->andFilterWhere(['like', 'nama_gudang', $this->nama_gudang]);

        return $dataProvider;
    }
}
