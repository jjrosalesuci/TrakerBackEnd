<?php

namespace app\controllers;

use Yii;
use app\models\DatDevice;

class DeviceController extends \yii\web\Controller
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
	
    public function actionCargar()
    {    
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $id      = $request->userId;

        $count = DatDevice::find()->count();
        $query = DatDevice::find();
        $data = $query->where(['id_user' => 3])->orderBy('id')->asArray()->all();
        echo json_encode(array('count' => $count, 'data' => $data));
    }

    public function actionGetdevices()
    {   
        $devices   = $_POST['devices'];
        $array_d   = json_decode($devices,true);

        $primaryConnection = \Yii::$app->db;
        $command = $primaryConnection->createCommand("SELECT * FROM `dat_device` WHERE id IN(".$array_d.")");
        $data = $command->queryAll(); 

        echo json_encode(array('data' => $data));
    }

    public function actionCreate()
    {
        $user = new DatDevice();

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $user->id_user    		= $request->userId;
        $user->code        		= $request->code;

		if(isset($request->registration)){
	        $user->registration	  = $request->registration;
		}
		
        $user->brand    		= $request->brand;
        $user->model    		= $request->model;
        $user->active         	= 'true';

        if ($user->save(false)) {
            $result = new \stdClass();
            $result->success = true;
            $result->msg = 'Se creo creo correctamente el dispositivo.';
            echo json_encode($result);
        } else {
            $result = new \stdClass();
            $result->success = false;
            $result->msg = 'Ocurrio un error.';
            echo json_encode($result);
        }      
    }

    public function actionCoordinates()
    {
        $itemsStr  = $_POST['body'];
        $id_device = $_POST['deviceid'];
		
		/*$nombre_archivo = "logs.txt"; 
		if($archivo = fopen($nombre_archivo, "a"))
		{
			fwrite($archivo," Device :".$_POST['deviceid']." data:" .$itemsStr."\n");			
		}*/
				
        $items     = json_decode($itemsStr,true);
        $cant      = count($items);
		
		$devices = DatDevice::find()->where(['code' => $id_device])->all();
		$device = $devices[0];
        if($device){
            $device->lat          = $items[$cant-1]['lat'];
            $device->lon          = $items[$cant-1]['lon'];
            $device->time         = $items[$cant-1]['time'];
            if ($device->save(false)) {
                $result = new \stdClass();
                $result->success = true;
                echo json_encode($result);
            }else {
                $result = new \stdClass();
                $result->success = false;
                echo json_encode($result);
            }  
        }else {
            $result = new \stdClass();
            $result->success = false;
            $result->msg = 'No se encontró el dispositivo.';
            echo json_encode($result);
        }
		
		
		//fclose($archivo);
    }

	public function actionUpdate()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $device 				  = $this->findModel($request->id);
        $device->code             = $request->code;
        $device->registration     = $request->registration;
        $device->brand            = $request->brand;
        $device->model            = $request->model;
       
        if ($device->save(false)) {
            $result = new \stdClass();
            $result->success = true;
            $result->msg = 'Se modifico correctamente el dispositivo.';
            echo json_encode($result);
        } else {
            $result = new \stdClass();
            $result->success = false;
            $result->msg = 'Ocurrio un error.';
            echo json_encode($result);
        }
    }

    public function actionActivate()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $device = $this->findModel($request->id);
        $device->active = $request->active;

        if ($device->save(false)) {
            $result = new \stdClass();
            $result->success = true;
            $result->msg = 'Se modifico correctamente el dispositivo.';
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
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $this->findModel($request->id)->delete();  

        $result = new \stdClass();
        $result->success = true;
        $result->msg = 'Se elimino correctamente el dispositivo.';
        echo json_encode($result);      
    }

    protected function findModel($id)
    {
        if (($model = DatDevice::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }

}
