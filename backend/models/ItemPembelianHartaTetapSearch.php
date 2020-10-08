<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ItemPembelianHartaTetap;

/**
 * ItemPembelianHartaTetapSearch represents the model behind the search form of `backend\models\ItemPembelianHartaTetap`.
 */
class ItemPembelianHartaTetapSearch extends ItemPembelianHartaTetap
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_pembelian_harta_tetap', 'id_pembelian_harta_tetap', 'id_harta_tetap', 'harga', 'diskon',], 'integer'],
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
        $query = ItemPembelianHartaTetap::find();

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
            'id_item_pembelian_harta_tetap' => $this->id_item_pembelian_harta_tetap,
            'id_pembelian_harta_tetap' => $this->id_pembelian_harta_tetap,
            'id_harta_tetap' => $this->id_harta_tetap,
            'harga' => $this->harga,
            'diskon' => $this->diskon,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
