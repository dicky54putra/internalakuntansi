<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktStokOpnameDetail;

/**
 * AktStokOpnameDetailSearch represents the model behind the search form of `backend\models\AktStokOpnameDetail`.
 */
class AktStokOpnameDetailSearch extends AktStokOpnameDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_opname_detail', 'id_stok_opname', 'id_item_stok', 'qty_opname', 'qty_program', 'qty_selisih'], 'integer'],
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
        $query = AktStokOpnameDetail::find();

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
            'id_stok_opname_detail' => $this->id_stok_opname_detail,
            'id_stok_opname' => $this->id_stok_opname,
            'id_item_stok' => $this->id_item_stok,
            'qty_opname' => $this->qty_opname,
            'qty_program' => $this->qty_program,
            'qty_selisih' => $this->qty_selisih,
        ]);

        return $dataProvider;
    }
}
