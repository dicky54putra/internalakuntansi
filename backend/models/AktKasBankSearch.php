<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktKasBank;

/**
 * AktKasBankSearch represents the model behind the search form of `backend\models\AktKasBank`.
 */
class AktKasBankSearch extends AktKasBank
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kas_bank', 'id_mata_uang', 'saldo', 'total_giro_keluar', 'id_akun', 'status_aktif'], 'integer'],
            [['kode_kas_bank', 'keterangan', 'jenis'], 'safe'],
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
        $query = AktKasBank::find();
        $query->joinWith(['akt_mata_uang']);
        $query->joinWith(['akt_akun']);

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
            'id_kas_bank' => $this->id_kas_bank,
            // 'id_mata_uang' => $this->id_mata_uang,
            'saldo' => $this->saldo,
            'total_giro_keluar' => $this->total_giro_keluar,
            // 'id_akun' => $this->id_akun,
            'status_aktif' => $this->status_aktif,
        ]);

        $query->andFilterWhere(['like', 'kode_kas_bank', $this->kode_kas_bank])
            ->andFilterWhere(['like', 'akt_akun.nama_akun', $this->id_akun])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'akt_mata_uang.mata_uang', $this->id_mata_uang])
            ->andFilterWhere(['like', 'jenis', $this->jenis]);

        return $dataProvider;
    }
}
