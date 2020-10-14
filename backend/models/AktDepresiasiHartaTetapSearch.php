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
            // [['id_pembelian_hart_tetap_detail'], 'integer'],
            [['kode_depresiasi', 'nilai', 'tanggal', 'id_pembelian_harta_tetap_detail'], 'safe'],
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
            'id_pembelian_harta_tetap_detail' => $this->id_pembelian_harta_tetap_detail,
            'kode_depresiasi' => $this->kode_depresiasi,
            'tanggal' => $this->tanggal,
            'nilai' => $this->nilai,
        ]);

        $query->andFilterWhere(['like', 'id_pembelian_harta_tetap_detail', $this->id_pembelian_harta_tetap_detail])
            ->andFilterWhere(['like', 'kode_depresiasi', $this->kode_depresiasi])
            ->andFilterWhere(['like', 'tanggal', $this->tanggal])
            ->andFilterWhere(['like', 'nilai', $this->nilai]);

        return $dataProvider;
    }
}
