<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktSaldoAwalAkunDetail;

/**
 * AktSaldoAwalAkunDetailSearch represents the model behind the search form of `backend\models\AktSaldoAwalAkunDetail`.
 */
class AktSaldoAwalAkunDetailSearch extends AktSaldoAwalAkunDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_saldo_awal_akun_detail', 'id_saldo_awal_akun', 'id_akun'], 'integer'],
            [['debet', 'kredit'], 'number'],
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
        $query = AktSaldoAwalAkunDetail::find();

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
            'id_saldo_awal_akun_detail' => $this->id_saldo_awal_akun_detail,
            'id_saldo_awal_akun' => $this->id_saldo_awal_akun,
            'id_akun' => $this->id_akun,
            'debet' => $this->debet,
            'kredit' => $this->kredit,
        ]);

        return $dataProvider;
    }
}
