<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktProduksiManualDetailBb;

/**
 * AktProduksiManualDetailBbSearch represents the model behind the search form of `backend\models\AktProduksiManualDetailBb`.
 */
class AktProduksiManualDetailBbSearch extends AktProduksiManualDetailBb
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_produksi_manual_detail_bb', 'id_produksi_manual', 'id_item_stok', 'qty'], 'integer'],
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
        $query = AktProduksiManualDetailBb::find();

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
            'id_produksi_manual_detail_bb' => $this->id_produksi_manual_detail_bb,
            'id_produksi_manual' => $this->id_produksi_manual,
            'id_item_stok' => $this->id_item_stok,
            'qty' => $this->qty,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
