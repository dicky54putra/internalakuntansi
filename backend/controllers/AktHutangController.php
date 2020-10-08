<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPembelian;
use backend\models\AktPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktMitraBisnis;
use backend\models\AktSales;
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use backend\models\AktItemStok;
use backend\models\Foto;
use backend\models\AktPembelianDetail;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * AktPembelianController implements the CRUD actions for AktPembelian model.
 */
class AktHutangController extends Controller
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
     * Lists all AktPembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPembelianSearch();
        $dataProvider = $searchModel->searchHutang(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
