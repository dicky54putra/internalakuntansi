<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktJurnalUmumDetail;

/**
 * AktJurnalUmumDetailSearch represents the model behind the search form of `backend\models\AktJurnalUmumDetail`.
 */
class AktJurnalUmumDetailSearch extends AktJurnalUmumDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jurnal_umum_detail', 'id_jurnal_umum', 'id_akun', 'debit', 'kredit'], 'integer'],
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
        $query = AktJurnalUmumDetail::find();

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
            'id_jurnal_umum_detail' => $this->id_jurnal_umum_detail,
            'id_jurnal_umum' => $this->id_jurnal_umum,
            'id_akun' => $this->id_akun,
            'debit' => $this->debit,
            'kredit' => $this->kredit,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
