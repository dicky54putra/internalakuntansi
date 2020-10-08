<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktMitraBisnisKontak;

/**
 * AktMitraBisnisKontakSearch represents the model behind the search form of `backend\models\AktMitraBisnisKontak`.
 */
class AktMitraBisnisKontakSearch extends AktMitraBisnisKontak
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mitra_bisnis_kontak', 'id_mitra_bisnis'], 'integer'],
            [['nama_kontak', 'jabatan', 'handphone', 'email'], 'safe'],
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
        $query = AktMitraBisnisKontak::find();

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
            'id_mitra_bisnis_kontak' => $this->id_mitra_bisnis_kontak,
            'id_mitra_bisnis' => $this->id_mitra_bisnis,
        ]);

        $query->andFilterWhere(['like', 'nama_kontak', $this->nama_kontak])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'handphone', $this->handphone])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
