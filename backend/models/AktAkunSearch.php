<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktAkun;

/**
 * AktAkunSearch represents the model behind the search form of `backend\models\AktAkun`.
 */
class AktAkunSearch extends AktAkun
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_akun', 'saldo_akun', 'header', 'parent', 'jenis', 'status_aktif','saldo_normal'], 'integer'],
            [['kode_akun', 'nama_akun', 'klasifikasi'], 'safe'],
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
        // $query = AktAkun::find()->where(['!=', 'id_akun', 1]);
        $query = AktAkun::find();
        $query->joinWith("akt_klasifikasi");

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
            'id_akun' => $this->id_akun,
            'saldo_akun' => $this->saldo_akun,
            'header' => $this->header,
            'parent' => $this->parent,
            'jenis' => $this->jenis,
            'saldo_normal' => $this->saldo_normal,
            // 'klasifikasi' => $this->klasifikasi,
            'status_aktif' => $this->status_aktif,
        ]);

        $query->andFilterWhere(['like', 'kode_akun', $this->kode_akun])
            ->andFilterWhere(['like', 'nama_akun', $this->nama_akun])
            ->andFilterWhere(['like', 'saldo_normal', $this->saldo_normal])
            ->andFilterWhere(['like', 'akt_klasifikasi.klasifikasi', $this->klasifikasi]);

        return $dataProvider;
    }

    public function searchLaporanDaftarAkun($params)
    {
        $query = AktAkun::find()->where(['!=', 'id_akun', 1]);
        $query->joinWith("akt_klasifikasi");

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
            'id_akun' => $this->id_akun,
            'saldo_akun' => $this->saldo_akun,
            'header' => $this->header,
            'parent' => $this->parent,
            'jenis' => $this->jenis,
            // 'klasifikasi' => $this->klasifikasi,
            'status_aktif' => $this->status_aktif,
        ]);

        $query->andFilterWhere(['like', 'kode_akun', $this->kode_akun])
            ->andFilterWhere(['like', 'nama_akun', $this->nama_akun])
            ->andFilterWhere(['like', 'akt_klasifikasi.klasifikasi', $this->klasifikasi]);

        return $dataProvider;
    }
}
