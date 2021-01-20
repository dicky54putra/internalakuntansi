<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\Userrole;

class LoginForm extends \yii\db\ActiveRecord
{


    //private $username;
    //private $password;
    private $_user = false;

    public static function tableName()
    {
        return '{{login}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string', 'max' => 20],
            ['password', 'validatePassword'],
        ];
    }


    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                Yii::$app->session->setFlash('danger', '<center>"Mohon Maaf, Username atau Password Anda salah"</center>');
                $this->addError($attribute, "Incorrect username or password");
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {

            // Dijalankan saat maintenance, comment setelah maintenance
            // $user = $this->getUser();
            // $id_login =  $user['id_login'];
            // if($id_login != 11) {
            //     Yii::$app->session->setFlash('danger', '<center>"Mohon Maaf, Sedang kami maintenance"</center>');
            // } else {
            //     return Yii::$app->user->login($this->getUser(), 0);
            // }

            // Uncommnet ini seteleah selesai maintenance
            return Yii::$app->user->login($this->getUser(), 0); 

        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Login::findByUsername($this->username);


            if ($this->_user) {

                $user_role = Userrole::find()->where(["id_login" => $this->_user->id_login])->all();
                //echo "1".var_dump($user_role); 
                $ids = [];
                $ids1 = [];
                foreach ($user_role as $data) {
                    $nama_role = Systemrole::find()->where(["id_system_role" => $data->id_system_role])->one();
                    //echo "2".var_dump($nama_role); 
                    $ids[] = $nama_role->nama_role;
                    $ids1[] = $data->id_system_role;
                }
                //exit;
                Yii::$app->session->set('user_role', $ids);
                Yii::$app->session->set('user_role_id', $ids1);

                //echo var_dump(Yii::$app->session->get('user_role_id'));
                //exit;
            }
        }
        return $this->_user;
    }
}
