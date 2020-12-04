<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktBom;

/**
 * AktBomSearch represents the model behind the search form of `backend\models\AktBom`.
 */
class AktBomSearch extends AktBom
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_bom', 'qty', 'status_bom'], 'integer'],
            [['keterangan', 'tipe', 'id_item_stok', 'no_bom'], 'safe'],
            [['total'], 'safe'],
            [['nama_item'], 'safe'],
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
        $query = AktBom::find();
        $query->select([
            'akt_bom.id_bom',
            'akt_bom.id_item_stok',
            'akt_bom.no_bom',
            'akt_bom.qty',
            'akt_bom.total',
            'akt_bom.status_bom',
            'akt_bom.tipe',
            'akt_bom.id_login',
            'akt_bom.tanggal_approve',
            'akt_bom.keterangan',
            'akt_item.nama_item',
        ]);
        $query->joinWith('item_stok');
        $query->leftJoin('akt_item', 'akt_item.id_item = akt_item_stok.id_item_stok');
        $query->orderBy('no_bom desc');


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
            'qty' => $this->qty,
            'total' => $this->total,
            'status_bom' => $this->status_bom,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'tipe', $this->tipe])
            ->andFilterWhere(['like', 'no_bom', $this->no_bom])
            ->andFilterWhere(['like', 'qty', $this->qty])
            ->andFilterWhere(['like', 'status_bom', $this->status_bom])
            ->andFilterWhere(['like', 'akt_item.id_item', $this->id_item_stok])
            ->andFilterWhere(['like', 'akt_item.nama_item', $this->nama_item]);

        return $dataProvider;
    }
}
