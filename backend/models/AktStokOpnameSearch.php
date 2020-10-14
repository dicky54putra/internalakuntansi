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

        // grid filtering conditions
        $query->andFilterWhere([
            'id_stok_opname' => $this->id_stok_opname,
            'tanggal_opname' => $this->tanggal_opname,
            'keterangan' => $this->keterangan,
            // 'id_akun_persediaan' => $this->id_akun_persediaan,
        ]);

        $query->andFilterWhere(['like', 'no_transaksi', $this->no_transaksi]);

        return $dataProvider;
    }
}
