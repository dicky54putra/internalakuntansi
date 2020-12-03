<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktTransferStok;

/**
 * AktTransferStokSearch represents the model behind the search form of `backend\models\AktTransferStok`.
 */
class AktTransferStokSearch extends AktTransferStok
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_transfer_stok'], 'integer'],
            [['no_transfer', 'tanggal_transfer', 'keterangan', 'id_gudang_asal', 'id_gudang_tujuan'], 'safe'],
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
        $query = AktTransferStok::find();
        $query->joinWith("gudang_asal");
        $query->joinWith("gudang_tujuan");

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

        if (!empty($this->tanggal_transfer)) {
            $query->andFilterWhere(["date_format(tanggal_transfer, '%d-%m-%Y')" => $this->tanggal_transfer]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_transfer_stok' => $this->id_transfer_stok,
        ]);

        $query->andFilterWhere(['like', 'no_transfer', $this->no_transfer])
            ->andFilterWhere(['like', 'gudang_asal.nama_gudang', $this->id_gudang_asal])
            ->andFilterWhere(['like', 'gudang_tujuan.nama_gudang', $this->id_gudang_tujuan])
            // ->andFilterWhere(['like', 'tanggal_transfer', $this->tanggal_transfer])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
