<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktItem;

/**
 * AktItemSearch represents the model behind the search form of `backend\models\AktItem`.
 */
class AktItemSearch extends AktItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item', 'status_aktif_item'], 'integer'],
            [['kode_item', 'barcode_item', 'nama_item', 'nama_alias_item', 'keterangan_item', 'id_tipe_item', 'id_merk', 'id_satuan', 'id_mitra_bisnis'], 'safe'],
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
        $query = AktItem::find();
        $query->joinWith(['tipe_item']);
        $query->joinWith(['merk']);
        $query->joinWith(['satuan']);
        $query->joinWith(['mitra_bisnis']);

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
            'id_item' => $this->id_item,
            // 'id_tipe_item' => $this->id_tipe_item,
            // 'id_merk' => $this->id_merk,
            'status_aktif_item' => $this->status_aktif_item,
        ]);

        $query->andFilterWhere(['like', 'kode_item', $this->kode_item])
            ->andFilterWhere(['like', 'barcode_item', $this->barcode_item])
            ->andFilterWhere(['like', 'nama_item', $this->nama_item])
            ->andFilterWhere(['like', 'nama_alias_item', $this->nama_alias_item])
            ->andFilterWhere(['like', 'akt_item_tipe.nama_tipe_item', $this->id_tipe_item])
            ->andFilterWhere(['like', 'akt_merk.nama_merk', $this->id_merk])
            ->andFilterWhere(['like', 'akt_satuan.nama_satuan', $this->id_satuan])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_mitra_bisnis])
            ->andFilterWhere(['like', 'keterangan_item', $this->keterangan_item]);

        return $dataProvider;
    }
}
