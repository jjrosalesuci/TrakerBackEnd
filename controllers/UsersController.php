<?php

namespace app\controllers;

use app\models\DatUser;
use Yii;
use yii\helpers\Url;


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
            $this->Notificar($user->username,$user->id,$user->email);
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

    private function Notificar($username, $user_id,$email){

        $cadena   = 'Estimado usuario '.$username.', bienvenido a nuestro sistema de monitoreo AsTraker, para acceder a nuestro sistema debe activar su cuenta accediendo al siguiente link :

'.Url::base().'/index.php?r=users/confirmar&id='.$user_id.'

Saludos cordiales
AsTraker
http://aseresoft.com/TrakerWebApp
http://aseresoft.com/';
        try{
            $message = Yii::$app->mailer->compose();
            $message->setFrom(array(Yii::$app->params["adminEmail"] =>  Yii::$app->params["adminNameSistem"]))
                    ->setTo($email)
                    ->setSubject('Confirmación de cuenta de usuario')
                    ->setTextBody($cadena)                            
                    ->send();
        }
            catch (Swift_TransportException $e) {
                Yii::$app->getSession()->setFlash('danger', $e->getMessage());
                return $this->render('smtpedit', array('model' => $has_smtp));
                return true;
        }
    }

    public function actionConfirmar()
    {
        $request = Yii::$app->request;
        $model   = $this->findModel($request->get('id'));

        if(!$model->active){
            $model->active = true;
            if ($model->save()) {
                /*$result = new \stdClass();
                $result->success = true;
                $result->msg = 'Se confirmó correctamente la cuenta.';
                echo json_encode($result);*/
                echo 'Se confirmó correctamente la cuenta, ya puede cerrar esta ventana.';
            } else {
                $result = new \stdClass();
                $result->success = false;
                $result->msg = 'Ocurrio un error.';
                echo json_encode($result);
            }      
        }else{
            echo "Su cuenta ya ha sido confirmada!";
            sleep(3);
            header('Location: http://aseresoft.com/TrakerWebApp/');
            exit;
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
