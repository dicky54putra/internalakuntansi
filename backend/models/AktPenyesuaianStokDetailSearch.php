<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenyesuaianStokDetail;

/**
 * AktPenyesuaianStokDetailSearch represents the model behind the search form of `backend\models\AktPenyesuaianStokDetail`.
 */
class AktPenyesuaianStokDetailSearch extends AktPenyesuaianStokDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penyesuaian_stok_detail', 'id_penyesuaian_stok', 'id_item_stok', 'qty', 'hpp', 'id_gudang'], 'integer'],
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
        $query = AktPenyesuaianStokDetail::find();

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
            'id_penyesuaian_stok_detail' => $this->id_penyesuaian_stok_detail,
            'id_penyesuaian_stok' => $this->id_penyesuaian_stok,
            'id_item_stok' => $this->id_item_stok,
            'qty' => $this->qty,
            'hpp' => $this->hpp,
            'id_gudang' => $this->id_gudang,
        ]);

        return $dataProvider;
    }
}
