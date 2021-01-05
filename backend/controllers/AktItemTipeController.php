<?php

namespace backend\controllers;

use backend\models\AktItem;
use Yii;
use backend\models\AktItemTipe;
use backend\models\AktItemTipeSearch;
use Error;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * AktItemTipeController implements the CRUD actions for AktItemTipe model.
 */
class AktItemTipeController extends Controller
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
     * Lists all AktItemTipe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktItemTipeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktItemTipe model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AktItemTipe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktItemTipe();

        if ($model->load(Yii::$app->request->post())) {

            $model->save();
            return $this->redirect(['view', 'id' => $model->id_tipe_item]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktItemTipe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_tipe_item]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktItemTipe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $db = Yii::$app->getDb();
        $dbname = 'dbname';
        $dsn = $db->dsn;
        $dbName = getDsnAttribute($dbname, $dsn);
        $columnName = 'id_tipe_item';
        $thisTable = 'akt_item_tipe';
        $thisId = $model->id_tipe_item;
        $rows = (new \yii\db\Query())
            ->select(['TABLE_NAME'])
            ->from('INFORMATION_SCHEMA.COLUMNS')
            ->where(['TABLE_SCHEMA' => $dbName])
            ->andWhere(['COLUMN_NAME' => $columnName])
            ->andWhere(['!=', 'TABLE_NAME', $thisTable])
            ->all();
        $array_table_name = array();
        $totalan_countData = 0;
        foreach ($rows as $key => $value) {
            # code...
            $rows2 = (new \yii\db\Query())
                ->select(['COUNT(*) as countData'])
                ->from($value['TABLE_NAME'])
                ->where([$columnName => $thisId])
                ->one();
            $array_table_name[] = $value['TABLE_NAME'] . ' - ' . $rows2['countData'];
            $totalan_countData += $rows2['countData'];
        }

        if ($totalan_countData == 0) {
            # code...
            $model->delete();
        } else {
            # code...
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Tipe Barang : <b>' . $model->nama_tipe_item . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktItemTipe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktItemTipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktItemTipe::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionCreateTipe()
    {
        $model = new AktItemTipe();
        $params = Yii::$app->getRequest()->getBodyParams();

        Yii::trace(print_r($params, true), __METHOD__);
        $model->load($params, '');

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            echo Json::encode('Data Tipe Berhasil Ditambahkan');
        } else {
            Yii::error($model->getErrors(), __METHOD__);
            throw new Error("Something wen't wrong");
        }
    }


    public function actionGetTipeBarang($sort)
    {
        $data = AktItemTipe::find()->select(['id_tipe_item', 'nama_tipe_item'])->orderBy([
            'id_tipe_item' => $sort == 1 ? SORT_DESC : SORT_ASC
        ])->all();
        echo Json::encode($data);
    }
}
