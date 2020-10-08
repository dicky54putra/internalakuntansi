<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ItemPenerimaanPembelian;

/**
 * ItemPenerimaanPembelianSearch represents the model behind the search form of `backend\models\ItemPenerimaanPembelian`.
 */
class ItemPenerimaanPembelianSearch extends ItemPenerimaanPembelian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_penerimaan_pembelian', 'id_pembelian', 'id_item_pembelian', 'qty'], 'integer'],
            [['tanggal', 'pengirim', 'penerima'], 'safe'],
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
        $query = ItemPenerimaanPembelian::find();

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
            'id_item_penerimaan_pembelian' => $this->id_item_penerimaan_pembelian,
            'id_pembelian' => $this->id_pembelian,
            'tanggal' => $this->tanggal,
            'id_item_pembelian' => $this->id_item_pembelian,
            'qty' => $this->qty,
        ]);

        $query->andFilterWhere(['like', 'pengirim', $this->pengirim])
            ->andFilterWhere(['like', 'penerima', $this->penerima]);

        return $dataProvider;
    }
}
