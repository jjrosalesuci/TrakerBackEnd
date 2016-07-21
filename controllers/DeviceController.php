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

    public function actionCreate()
    {
        $user = new DatDevice();

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $user->id_user    		= $request->userId;
        $user->code        		= $request->code;
        $user->registration		= $request->registration;
        $user->brand    		= $request->brand;
        $user->model    		= $request->model;
        $user->active         	= 'true';

        if ($user->save()) {
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
        $items     = json_decode($itemsStr,true);
        $cant      = count($items);

        if(($device = DatDevice::findOne($id_device)) !== null){
            $device->lat          = $items[$cant-1]['lat'];
            $device->lon          = $items[$cant-1]['lon'];
            $device->time         = $items[$cant-1]['time'];

            if ($device->save()) {
                $result = new \stdClass();
                $result->success = true;
                $result->msg = 'Las coordenadas fueron guardadas.';
                echo json_encode($result);
            }else {
                $result = new \stdClass();
                $result->success = false;
                $result->msg = 'Error!!. Las coordenadas no fueron guardadas.';
                echo json_encode($result);
            }  
        }else {
            $result = new \stdClass();
            $result->success = false;
            $result->msg = 'No se encontró el dispositivo.';
            echo json_encode($result);
        }      
    }

	public function actionUpdate()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $device = $this->findModel($request->id);
        $device->code             = $request->code;
        $device->registration     = $request->registration;
        $device->brand            = $request->brand;
        $device->model            = $request->model;
        $device->active         	= $request->active;

        if ($device->save()) {
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
        $device->active           = $request->active;

        if ($device->save()) {
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
