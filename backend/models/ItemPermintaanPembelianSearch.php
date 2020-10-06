<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ItemPermintaanPembelian;

/**
 * ItemPermintaanPembelianSearch represents the model behind the search form of `backend\models\ItemPermintaanPembelian`.
 */
class ItemPermintaanPembelianSearch extends ItemPermintaanPembelian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_permintaan_pembelian', 'id_permintaan_pembelian', 'id_item_stok', 'quantity', 'satuan', 'id_departement', 'id_proyek'], 'integer'],
            [['keterangan', 'req_date'], 'safe'],
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
        $query = ItemPermintaanPembelian::find();

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
            'id_item_permintaan_pembelian' => $this->id_item_permintaan_pembelian,
            'id_permintaan_pembelian' => $this->id_permintaan_pembelian,
            'id_item_stok' => $this->id_item_stok,
            'quantity' => $this->quantity,
            'satuan' => $this->satuan,
            'id_departement' => $this->id_departement,
            'id_proyek' => $this->id_proyek,
            'req_date' => $this->req_date,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
