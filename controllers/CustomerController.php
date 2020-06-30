<?php

namespace app\controllers;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use app\models\Customer;

class CustomerController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'optional' => [
                'login',
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()

    {
        return $this->render('index');
    }

public function actionCreateCustomer()
   {
    
      \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
      $customer = new Customer();
      $customer->scenario = Customer:: SCENARIO_CREATE;
      $customer->attributes = \yii::$app->request->post();
      if($customer->validate())
      {
       $customer->save();
       return array('status' => true, 'data'=> 'Customer record is successfully updated');
      }
      else
      {
       return array('status'=>false,'data'=>$customer->getErrors());    
      }
}

public function actionGetCustomer()
{
    \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
    $customer = Customer::find()->all();
    if(count($customer) > 0 )
    {
        return array('status' => true, 'data'=> $customer);
    }
    else
    {
        return array('status'=>false,'data'=> 'No Customer Found');
    }
}


public function actionDeleteCustomer()
{
\Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
 $attributes = \yii::$app->request->post();
     $customer = Customer::find()->where(['ID' => $attributes['id'] ])->one();  
      if($customer != null)
  {
       $customer->delete();
  return array('status' => true, 'data'=> 'Customer record is successfully deleted'); 
      }
else
{
return array('status'=>false,'data'=> 'No Customer Found');
}
}

}
