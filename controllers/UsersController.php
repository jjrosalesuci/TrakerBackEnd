<?php

namespace app\controllers;

use app\models\DatUser;
use Yii;


class UsersController extends \yii\web\Controller
{
    
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }
	
	public function behaviors()
	{
		return [
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
			],
		];
	}

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $user = new DatUser();

        $user->username    = $request->get('username');
        $user->names       = $request->get('names');
        $user->lastname    = $request->get('lastname');
        $user->sex         = $request->get('sex');
        $user->email       = $request->get('email');
        $user->role        = $request->get('role');

        $user->setPassword($request->get('password'));
        $user->generateAuthKey();

        if ($user->save()) {
            $result = new \stdClass();
            $result->success = true;
            $result->msg = 'Se creo correctamente el usuario.';
            echo json_encode($result);
        } else {
            $result = new \stdClass();
            $result->success = false;
            $result->msg = 'Ocurrio un error.';
            echo json_encode($result);
        }      
    }

    public function actionSignup()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $user = new DatUser();

        $user->username    = $request->user;
        $user->email       = $request->email;
        $user->role        = 'usuario';
		$user->active      = false;

        $user->setPassword($request->password);
        $user->generateAuthKey();

        if ($user->save(false)) {
            $result = new \stdClass();
            $result->success = true;
            $result->msg = 'Se creo correctamente el usuario.';
            echo json_encode($result);
        } else {
            $result = new \stdClass();
            $result->success = false;
            $result->msg = 'Ocurrio un error.';
            echo json_encode($result);
        }      
    }

    public function actionCargar_usuarios()
    {       
        $request = Yii::$app->request;        
        $offset  = $request->post('start');
        $limit   = $request->post('limit');        

        if ($offset == NULL) {
            $offset = 0;
        }
        if ($limit == NULL) {
            $limit = 12;
        }

        $count = DatUser::find()->count();
        $query = DatUser::find();
        $data = $query->offset($offset)->limit($limit)->orderBy('id')->asArray()->all();
        echo json_encode(array('count' => $count, 'data' => $data));
    }

    public function actionUpdate()
    {
        $request           = Yii::$app->request;
        $id                = $request->get('id');

        $user = $this->findModel($id);
        $user->username    = $request->get('username');
        $user->names       = $request->get('names');
        $user->lastname    = $request->get('lastname');
        $user->sex         = $request->get('sex');
        $user->email       = $request->get('email');
        $user->role        = $request->get('role');

        if ($user->save()) {
            $result = new \stdClass();
            $result->success = true;
            $result->msg = 'Se modifico correctamente el usuario.';
            echo json_encode($result);
        } else {
            $result = new \stdClass();
            $result->success = false;
            $result->msg = 'Ocurrio un error.';
            echo json_encode($result);
        }
    }

    public function actionUpdatepassword(){

        $request       = Yii::$app->request;
        $id            = $request->get('id_user');
        $password      = $request->get('password');

        $model = $this->findModel($id);
        $model->setPassword($password); 

        if ($model->save()) {
            $result = new \stdClass();
            $result->success = true;
            $result->msg = 'Se modifico correctamente la contraseña.';
            echo json_encode($result);
        } else {
            $result = new \stdClass();
            $result->success = false;
            $result->msg = 'Ocurrio un error.';
            echo json_encode($result);
        }
    }

    public function actionDelete()
    {
        $request    = Yii::$app->request;
        $id         = $request->get('id');
        $this->findModel($id)->delete();  

        $result = new \stdClass();
        $result->success = true;
        $result->msg = 'Se elimino correctamente el usuario.';
        echo json_encode($result);      
    }

    protected function findModel($id)
    {
        if (($model = DatUser::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }

}
