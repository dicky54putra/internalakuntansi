<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenawaranPenjualan;

/**
 * AktPenawaranPenjualanSearch represents the model behind the search form of `backend\models\AktPenawaranPenjualan`.
 */
class AktPenawaranPenjualanSearch extends AktPenawaranPenjualan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penawaran_penjualan', 'no_penawaran_penjualan', 'id_customer', 'id_sales', 'id_mata_uang', 'pajak', 'id_penagih', 'id_pengirim', 'status'], 'integer'],
            [['tanggal', 'tanggal_approve', 'the_approver'], 'safe'],
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
        $query = AktPenawaranPenjualan::find()->orderBy("id_penawaran_penjualan DESC");
        $query->joinWith("login");

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
            'id_penawaran_penjualan' => $this->id_penawaran_penjualan,
            'no_penawaran_penjualan' => $this->no_penawaran_penjualan,
            'tanggal' => $this->tanggal,
            'id_customer' => $this->id_customer,
            'id_sales' => $this->id_sales,
            'id_mata_uang' => $this->id_mata_uang,
            'pajak' => $this->pajak,
            'id_penagih' => $this->id_penagih,
            'id_pengirim' => $this->id_pengirim,
            'status' => $this->status,
            'tanggal_approve' => $this->tanggal_approve,
        ]);

        $query->andFilterWhere(['like', 'login.nama', $this->the_approver]);

        return $dataProvider;
    }
}
