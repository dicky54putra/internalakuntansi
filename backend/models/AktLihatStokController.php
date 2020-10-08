<?php

namespace backend\controllers;

use backend\models\AktItemStokSearch;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * AktKotaController implements the CRUD actions for AktKota model.
 */
class AktLihatStokController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AktKota models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktItemStokSearch();
        $dataProvider = $searchModel->search_lihat_stok(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
