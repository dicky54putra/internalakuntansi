<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MenuNavigasi;

/**
 * MenuNavigasiSearch represents the model behind the search form of `backend\models\MenuNavigasi`.
 */
class MenuNavigasiSubSearch extends MenuNavigasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_menu', 'id_parent', 'no_urut', 'status'], 'integer'],
            [['nama_menu', 'url', 'icon','parent'], 'safe'],
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
        $query = MenuNavigasi::find()
        ->select(["b.nama_menu as parent","menu_navigasi.*"])->leftJoin("menu_navigasi b","menu_navigasi.id_parent = b.id_menu")
        ->where(["menu_navigasi.id_parent"=>Yii::$app->request->get('id')])->orderBy("no_urut");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['parent'] = [
            'asc' => ['b.nama_menu' => SORT_ASC],
            'desc' => ['b.nama_menu' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_menu' => $this->id_menu,
            'id_parent' => $this->id_parent,
            'no_urut' => $this->no_urut,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'nama_menu', $this->nama_menu])
        ->andFilterWhere(['like', 'url', $this->url])
        ->andFilterWhere(['like', 'b.nama_menu', $this->parent])
        ->andFilterWhere(['like', 'icon', $this->icon]);

        return $dataProvider;
    }
}
