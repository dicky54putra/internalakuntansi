<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktItemHargaJual;

/**
 * AktItemHargaJualSearch represents the model behind the search form of `backend\models\AktItemHargaJual`.
 */
class AktItemHargaJualSearch extends AktItemHargaJual
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_harga_jual', 'id_item', 'id_mata_uang', 'id_level_harga', 'harga_satuan', 'diskon_satuan'], 'integer'],
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
        $query = AktItemHargaJual::find();

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
            'id_item_harga_jual' => $this->id_item_harga_jual,
            'id_item' => $this->id_item,
            'id_mata_uang' => $this->id_mata_uang,
            'id_level_harga' => $this->id_level_harga,
            'harga_satuan' => $this->harga_satuan,
            'diskon_satuan' => $this->diskon_satuan,
        ]);

        return $dataProvider;
    }
}
