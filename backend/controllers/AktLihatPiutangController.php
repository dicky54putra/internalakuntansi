<?php

namespace backend\controllers;

use Yii;
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktKotaController implements the CRUD actions for AktKota model.
 */
class AktLihatPiutangController extends Controller
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
        $model_kas = Yii::$app->db->createCommand("SELECT * FROM akt_kas_bank LEFT JOIN akt_mata_uang ON akt_mata_uang.id_mata_uang = akt_kas_bank.id_mata_uang")->query();
        $model_mata_uang = new AktMataUang;
        return $this->render('index', [
            'model_kas' => $model_kas,
            'model_mata_uang' => $model_mata_uang
        ]);
    }
}
