<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktStokOpname;

/**
 * AktStokOpnameSearch represents the model behind the search form of `backend\models\AktStokOpname`.
 */
class AktStokOpnameSearch extends AktStokOpname
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_opname'], 'integer'],
            [['no_transaksi', 'tanggal_opname', 'keterangan'], 'safe'],
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
        $query = AktStokOpname::find();

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

        if (!empty($this->tanggal_opname)) {
            $query->andFilterWhere(["date_format(tanggal_opname, '%d-%m-%Y')" => $this->tanggal_opname]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_stok_opname' => $this->id_stok_opname,
        ]);

        $query->andFilterWhere(['like', 'no_transaksi', $this->no_transaksi])
            // ->andFilterWhere(['like', 'tanggal_opname', $this->tanggal_opname])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);


        return $dataProvider;
    }
}
