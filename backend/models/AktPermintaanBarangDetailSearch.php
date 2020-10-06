<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPermintaanBarangDetail;

/**
 * AktPermintaanBarangDetailSearch represents the model behind the search form of `backend\models\AktPermintaanBarangDetail`.
 */
class AktPermintaanBarangDetailSearch extends AktPermintaanBarangDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_permintaan_barang_detail', 'id_permintaan_barang', 'id_item', 'qty', 'qty_ordered', 'qty_rejected'], 'integer'],
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
        $query = AktPermintaanBarangDetail::find();

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
            'id_permintaan_barang_detail' => $this->id_permintaan_barang_detail,
            'id_permintaan_barang' => $this->id_permintaan_barang,
            'id_item' => $this->id_item,
            'qty' => $this->qty,
            'qty_ordered' => $this->qty_ordered,
            'qty_rejected' => $this->qty_rejected,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
