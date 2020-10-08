<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use backend\models\DataKecamatan;

/**
 * This is the model class for table "login".
 *
 * @property integer $id_login
 * @property string $username
 * @property string $password
 * @property string $nama
 */
class Login extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username',  'nama'], 'required'],
            [['username'], 'string', 'max' => 20],
            [['username'], 'unique'],
            [['password'], 'string', 'max' => 32],
            [['nama'], 'string', 'max' => 30],
            [['foto'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_login' => 'Id Login',
            'username' => 'Username',
            'password' => 'Password',
            'nama' => 'Nama',
            'foto' => 'Foto',
        ];
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {

        return $this->password === md5($password);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException(); //I don't implement this method because I don't have any access token column in my database
    }

    public function getId()
    {
        return $this->id_login;
    }

    public function getAuthKey()
    {
        throw new NotSupportedException();
        //return $this->authKey;//Here I return a value of my authKey column
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException();
        //return $this->authKey === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //if ($this->password != "") {
            //    $this->password = md5($this->password);
			//	//exit;
            //}
			 

            if ($this->foto) {
                $filename = time() . "_" . str_replace(" ", "_", $this->foto->baseName) . '.' . $this->foto->extension;
                $this->foto->saveAs('upload/' . $filename);
                $this->foto = $filename;
            } else {
                if (Yii::$app->request->get('id')) {
                    $foto = Login::findOne(Yii::$app->request->get('id'));
                    $this->foto = $foto->foto;
                } else {
                    $this->foto = "avatar5.png";
                }
            }
            return true;
        }
    }



    public function getHakakses()
    {
        return $this->hasMany(Hakakses::className(), ["id_login" => "id_login"]);
    }
}
