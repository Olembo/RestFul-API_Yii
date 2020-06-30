<?php

namespace app\controllers;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\web\Response;
use app\models\User;
use yii\filters\auth\HttpBearerAuth;

class AuthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }
    
        
    
    public function actionRegister()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = new User();
        if(isset($_POST['username'])  && isset($_POST['email']) && isset($_POST['password'])){
            $user->username = $_POST['username'];
            $user->email = $_POST['email'];
            $user->setPassword($_POST['password']);
            $user->generateAuthKey();
            //$user->attributes = \yii::$app->request->post();
        }else{
            return array('status' => false, 'data'=> 'username password email are required');
        }
        if($user->validate())
        {
            $user->save();
            return array('status' => true, 'data'=> 'user has been recorded');
        }
        else
        {
            return array('status'=>false,'data'=>$user->getErrors());    
        } 
    }
    public function actionLogin(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($_POST['username']) && isset($_POST['password'])){
            $user = null;
            if (User::findByUsername($_POST['username'])){
                $user = User::findByUsername($_POST['username']);
                if(!$user->validatePassword($_POST['password'])){
                    $user = null;
                }
            }
            if($user != null){
                Yii::$app->user->login($user, 0);
                $user->generateBearerToken();
                $user->save();
                return $user->getAuthKey();
            }
            return array('status' => false, 'data'=> 'username and password not matched');
            
        }
        return array('status' => false, 'data'=> 'username and password are required');
        
    }


    
    

}
