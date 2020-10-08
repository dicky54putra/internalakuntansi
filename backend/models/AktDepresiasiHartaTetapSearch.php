<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktDepresiasiHartaTetap;


/**
 * AktDepresiasiHartaTetapSearch represents the model behind the search form of `backend\models\AktDepresiasiHartaTetap`.
 */
class AktDepresiasiHartaTetapSearch extends AktDepresiasiHartaTetap
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_depresiasi_harta_tetap'], 'integer'],
            [['kode_depresiasi', 'nilai', 'tanggal'], 'safe'],
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
        $query = AktDepresiasiHartaTetap::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_depresiasi_harta_tetap' => $this->id_depresiasi_harta_tetap,
            'kode_depresiasi' => $this->kode_depresiasi,
            'tanggal' => $this->tanggal,
            'nilai' => $this->nilai,
        ]);

        $query->andFilterWhere(['like', 'id_depresiasi_harta_tetap', $this->id_depresiasi_harta_tetap])
            ->andFilterWhere(['like', 'kode_depresiasi', $this->kode_depresiasi])
            ->andFilterWhere(['like', 'tanggal', $this->tanggal])
            ->andFilterWhere(['like', 'nilai', $this->nilai]);

        return $dataProvider;
    }
}
