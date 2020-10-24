<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktItemStok;

/**
 * AktItemStokSearch represents the model behind the search form of `backend\models\AktItemStok`.
 */
class AktItemStokSearch extends AktItemStok
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_stok', 'qty', 'hpp', 'min'], 'integer'],
            [['location', 'id_item', 'id_gudang'], 'safe'],
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
        $query = AktItemStok::find();
        $query->joinWith(['item']);
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
            'id_item_stok' => $this->id_item_stok,
            'id_item' => $this->id_item,
            'id_gudang' => $this->id_gudang,
            'qty' => $this->qty,
            'hpp' => $this->hpp,
            'min' => $this->min,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }

    public function searchLihatStok($params)
    {
        $query = AktItemStok::find();
        $query->joinWith(['item']);
        $query->joinWith(['gudang']);
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
            'id_item_stok' => $this->id_item_stok,
            // 'id_item' => $this->id_item,
            // 'id_gudang' => $this->id_gudang,
            // 'qty' => $this->qty,
            // 'hpp' => $this->hpp,
            // 'min' => $this->min,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'akt_item.nama_item', $this->id_item])
            ->andFilterWhere(['like', 'akt_gudang.nama_gudang', $this->id_gudang])
            ->andFilterWhere(['like', 'qty', $this->qty])
            ->andFilterWhere(['like', 'hpp', $this->hpp])
            ->andFilterWhere(['like', 'min', $this->min]);

        return $dataProvider;
    }

    public function search_lihat_stok($params)
    {
        $query = AktItemStok::find()
            ->select([
                "akt_item_stok.id_item_stok",
                "akt_item.nama_item",
                "akt_gudang.nama_gudang",
                "akt_item_stok.qty",
                "akt_item_stok.id_item",
                "akt_item_stok.id_gudang",
                "akt_item_stok.min",
                "akt_item_stok.location",
                "akt_item_stok.hpp",
            ])
            ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
            ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
            ->orderBy("akt_item.nama_item ASC");
        // ->asArray();
        // ->all();
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
            'id_item_stok' => $this->id_item_stok,
            // 'id_item' => $this->id_item,
            // 'id_gudang' => $this->id_gudang,
            // 'qty' => $this->qty,
            // 'hpp' => $this->hpp,
            // 'min' => $this->min,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'akt_item.nama_item', $this->id_item])
            ->andFilterWhere(['like', 'akt_gudang.nama_gudang', $this->id_gudang])
            ->andFilterWhere(['like', 'qty', $this->qty])
            ->andFilterWhere(['like', 'hpp', $this->hpp])
            ->andFilterWhere(['like', 'min', $this->min]);

        return $dataProvider;
    }
}
