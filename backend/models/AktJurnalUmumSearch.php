<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktJurnalUmum;

/**
 * AktJurnalUmumSearch represents the model behind the search form of `backend\models\AktJurnalUmum`.
 */
class AktJurnalUmumSearch extends AktJurnalUmum
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jurnal_umum', 'no_jurnal_umum', 'tanggal', 'tipe'], 'integer'],
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
        $query = AktJurnalUmum::find()->where(['tipe' => 1])->orderBy('id_jurnal_umum DESC');

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
            'id_jurnal_umum' => $this->id_jurnal_umum,
            'no_jurnal_umum' => $this->no_jurnal_umum,
            'tanggal' => $this->tanggal,
            'tipe' => $this->tipe,
            'keterangan' => $this->keterangan,
        ]);

        return $dataProvider;
    }

    public function searchAktJurnalUmumPenyesuaian($params)
    {
        $query = AktJurnalUmum::find()->where(['tipe' => 2]);

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
            'id_jurnal_umum' => $this->id_jurnal_umum,
            'no_jurnal_umum' => $this->no_jurnal_umum,
            'tanggal' => $this->tanggal,
            'tipe' => $this->tipe,
            'keterangan' => $this->keterangan,
        ]);

        return $dataProvider;
    }
}
