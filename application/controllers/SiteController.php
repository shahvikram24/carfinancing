<?php

namespace app\controllers;

use app\models\Application;
use app\models\Pages;
use app\models\Provinces;
use app\models\VehicleTypes;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new VehicleTypes();
        $oPageModel = new Pages();

        $vehicles = $model::find()->all();
        $content = $oPageModel::find()->where(array('keyword' => 'index'))->one();

        return $this->render('index',[
            'model' => $model,
            'vehicles' => $vehicles,
            'content' => $content,
        ]);
    }

    /**
     * Display steps form
     *
     * @return string
     */
    public function actionVehicle(){
        $error = "";
        $model = new VehicleTypes();
        $pModel = new Provinces();
        $oModel = new Application();
        $oPageModel = new Pages();

        $provinces = $pModel::find(['is_active' => 1])->orderBy('name')->asArray()->all();
        $vehicle = (Yii::$app->request->post('vehicle')) ? Yii::$app->request->post('vehicle') : 'sedan';
        $vType = $model::find()->where(array('keyword' => $vehicle))->one();
        $content = $oPageModel::find(['is_active' => 1])->asArray()->all();
        foreach($content as $v){
            $content[$v['keyword']] = $v['description'];
        }

        return $this->render('steps', [
            'error'   => $error,
            'vehicle' => $vType['id'],
            'provinces' => $provinces,
            'model' => $model,
            'oModel' => $oModel,
            'content' => $content,
        ]);
    }

    public function actionFinish(){
        $model = new Application();
        $oPageModel = new Pages();
        $content = $oPageModel::find()->where(array('keyword' => 'step_f_inf'))->one();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()) {

                $subject = "New application was created.";

                $headers = "From: " . strip_tags(Yii::$app->request->post('email')) . PHP_EOL;
                $headers .= "MIME-Version: 1.0" . PHP_EOL;
                $headers .= "Content-Type: text/html; charset=ISO-8859-1" . PHP_EOL;

                $message = "Hello, " . PHP_EOL;
                $message .= $this->renderPartial('email/application', array('model' => $model::findOne($model->id)));

                @mail(Yii::$app->params['adminEmail'], $subject, $message, $headers);

                $msg = $this->renderPartial('order_thanks_message', array('content' => $content));
                $response = array('type' => 'success', 'msg' => $msg);
            } else {
                $response = array('type' => 'error', 'msg' => 'Something went wrong please try again.');
            }
        } else {
            $errors = $model->errors;
            $msg = 'Please check all inputs to fix the error: ' . PHP_EOL;
            if(!empty($errors)) {
                foreach($errors as $k => $v){
                    $msg .= $v[0] . PHP_EOL;
                }

            } else{
                $msg = 'Something went wrong please try again.';
            }
            $response = array('type' => 'error', 'msg' => $msg);
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;

    }

    public function actionValidate(){
        $model = new Application();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return TRUE;
        }
        else {
            return false;
        }
    }

    public function actionTerms(){
        $oPageModel = new Pages();
        $content = $oPageModel::find()->where(array('keyword' => 'terms'))->one();
        if(!empty($content)){

            return $this->render('page_details', [
               'model' => $oPageModel,
               'content' => $content,
            ]);
        } else {
            return $this->goHome();
        }
    }

    public function actionPrivacy(){
        $oPageModel = new Pages();
        $content = $oPageModel::find()->where(array('keyword' => 'privacy'))->one();
        if(!empty($content)){

            return $this->render('page_details', [
               'model' => $oPageModel,
               'content' => $content,
            ]);
        } else {
            return $this->goHome();
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
