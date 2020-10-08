<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktTransferKas;

/**
 * AktTransferKasSearch represents the model behind the search form of `backend\models\AktTransferKas`.
 */
class AktTransferKasSearch extends AktTransferKas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_transfer_kas', 'no_transfer_kas', 'id_asal_kas', 'id_tujuan_kas'], 'integer'],
            [['tanggal', 'keterangan'], 'safe'],
            [['jumlah1', 'jumlah2'], 'number'],
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
        $query = AktTransferKas::find();
        $query->joinWith(['kas_bank']);

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
            'id_transfer_kas' => $this->id_transfer_kas,
            'no_transfer_kas' => $this->no_transfer_kas,
            'tanggal' => $this->tanggal,
            'id_asal_kas' => $this->id_asal_kas,
            'id_tujuan_kas' => $this->id_tujuan_kas,
            'jumlah1' => $this->jumlah1,
            'jumlah2' => $this->jumlah2,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
