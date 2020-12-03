<?php

namespace backend\controllers;

use Yii;
use backend\models\Login;
use backend\models\LoginSearch;
use backend\models\Systemrole;
use backend\models\Userrole;
use backend\models\DataDesa;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LoginController implements the CRUD actions for Login model.
 */
class LoginController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'profile', 'hakakses'],
                        'roles' => ['Login'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Login models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit;
        }

        $searchModel = new LoginSearch();
        $userrole = Yii::$app->db->createCommand("SELECT system_role.nama_role FROM user_role INNER JOIN system_role ON system_role.id_system_role = user_role.id_system_role WHERE user_role.id_login = " . Yii::$app->user->id . " AND  system_role.nama_role = 'DEVELOPER'")->queryScalar();
        if ($userrole == 'DEVELOPER') {
            $dataProvider = $searchModel->search_dev(Yii::$app->request->queryParams);
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Login model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit;
        }
        $userrole = Yii::$app->db->createCommand("SELECT system_role.nama_role FROM user_role INNER JOIN system_role ON system_role.id_system_role = user_role.id_system_role WHERE user_role.id_login = " . Yii::$app->user->id . " AND  system_role.nama_role = 'DEVELOPER'")->queryScalar();
        if ($userrole == 'DEVELOPER') {
            $hakakses = Systemrole::find()->orderBy("nama_role")->all();
        } else {
            $hakakses = Systemrole::find()->orderBy("nama_role")->where(['!=', 'nama_role', 'DEVELOPER'])->all();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'hakakses' => $hakakses,
        ]);
    }

    public function actionProfile($id)
    {
        if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit;
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->foto = UploadedFile::getInstance($model, 'foto');
            if ($model->password == "") {
                $data = Login::findOne($id);
                $model->password = $data->password;
            } else {
                $model->password = md5($model->password);
            }
            $userrole = Yii::$app->db->createCommand("SELECT system_role.nama_role FROM user_role INNER JOIN system_role ON system_role.id_system_role = user_role.id_system_role WHERE user_role.id_login = " . Yii::$app->user->id . " AND  system_role.nama_role = 'DEMO PROGRAM'")->queryScalar();
            if ($userrole == 'DEMO PROGRAM') {
                Yii::$app->session->setFlash('danger', [['Berhasil!', 'Mohon Maaf, Adnda tidak bisa mgubah profil dengan akun demo!']]);
            } else {
                $model->save();
                Yii::$app->user->logout();
                return $this->goHome();

                Yii::$app->session->setFlash('success', [['Berhasil!', '
                    <p>Data Profil Berhasil Di Ubah.</p>
                    <p>Silahkan Login Dengan Username dan Password Yang Baru Diubah</p>
                ']]);
            }
        }

        return $this->render('view_profile', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionHakakses($id)
    {
        if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit;
        }


        if (is_array(Yii::$app->request->post('data'))) {
            Userrole::deleteAll(["id_login" => $id]);
            //echo var_dump(Yii::$app->request->post('data'))."<br>";
            foreach (Yii::$app->request->post('data') as $key => $data) {
                $cek = Userrole::find()->where(["id_system_role" => $key, "id_login" => $id])->count();
                if ($cek < 1) {
                    $simpan = new Userrole();
                    $simpan->id_system_role = $key;
                    $simpan->id_login = $id;
                    $simpan->save(false);
                }
            }

            Yii::$app->session->setFlash("success", "Data hak akses berhasil disimpan.");
        } else {
            Userrole::deleteAll(["id_login" => $id]);
        }



        $hakakses = Systemrole::find()->orderBy("nama_role")->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'hakakses' => $hakakses,
        ]);
    }

    /**
     * Creates a new Login model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit;
        }

        $model = new Login();

        if ($model->load(Yii::$app->request->post())) {


            $model->foto = UploadedFile::getInstance($model, 'foto');
            if ($model->password != "") {
                $model->password = md5($model->password);
            }

            $model->save();

            if (empty($model->id_login)) {
                # code...
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Username yang di inputkan sudah di gunakan.']]);
                return $this->redirect(['create']);
            } else {
                # code...
                return $this->redirect(['view', 'id' => $model->id_login]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Login model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit;
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->foto = UploadedFile::getInstance($model, 'foto');
            if ($model->password == "") {
                $data = Login::findOne($id);
                $model->password = $data->password;
            } else {
                $model->password = md5($model->password);
            }
            $model->save();


            return $this->redirect(['view', 'id' => $model->id_login]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Login model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit;
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Login model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Login the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Login::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
