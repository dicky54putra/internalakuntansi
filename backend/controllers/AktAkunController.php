<?php

namespace backend\controllers;

use Yii;
use backend\models\AktAkun;
use backend\models\AktAkunSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktAkunController implements the CRUD actions for AktAkun model.
 */
class AktAkunController extends Controller
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
     * Lists all AktAkun models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktAkunSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $id_login =  Yii::$app->user->identity->id_login;

        $id_system_role = Yii::$app->db->createCommand("SELECT id_system_role from user_role WHERE id_login = '$id_login'")->queryScalar();

        if ($id_system_role == 9) {
            $permission_button = "{view} {update} {delete}";
        } else {
            $permission_button = "{view} {update}";
        }


        return $this->render('index', [
            'permission_button' => $permission_button,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktAkun model.
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
     * Creates a new AktAkun model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktAkun();

        // $total = AKtAkun::find()->count();
        // $nomor = 'AK' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);
        $model->saldo_akun = 0;
        $id_akun_max = AktAkun::find()->select(['max(id_akun) as id_akun'])->one();
        $nomor_sebelumnya = AktAkun::find()->select(['kode_akun'])->where(['id_akun' => $id_akun_max])->one();
        if (!empty($nomor_sebelumnya->kode_akun)) {
            # code...
            $noUrut = (int) substr($nomor_sebelumnya->kode_akun, 2);
            if ($noUrut <= 999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
            } elseif ($noUrut <= 9999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%04s", $noUrut);
            } elseif ($noUrut <= 99999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%05s", $noUrut);
            }
            $kode_akun = "AK" . $noUrut_2;
            $nomor = $kode_akun;
        } else {
            # code...
            $nomor = 'AK001';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_akun]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Updates an existing AktAkun model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $nomor = $model->kode_akun;
        $sum_kas_bank = Yii::$app->db->createCommand("SELECT SUM(saldo) FROM akt_kas_bank")->queryScalar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_akun]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'sum_kas_bank' => $sum_kas_bank,
        ]);
    }

    /**
     * Deletes an existing AktAkun model.
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
        $columnName = 'id_akun';
        $thisTable = 'akt_akun';
        $thisId = $model->id_akun;
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
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Akun : <b>' . $model->nama_akun . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktAkun model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktAkun the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktAkun::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
