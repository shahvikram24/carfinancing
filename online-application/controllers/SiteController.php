<?php

namespace app\controllers;

use app\models\Affiliate;
use app\models\AffiliateTransaction;
use app\models\Contact;
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
     * display homepage
     *
     * @param null $referral
     *
     * @return string
     */
    public function actionIndex($referral = null)
    {
        $model = new VehicleTypes();
        $oPageModel = new Pages();
        $isAffiliate = false;

        $vehicles = $model::find()->all();
        $content = $oPageModel::find()->where(array('keyword' => 'index'))->one();

        if(!empty($referral)) {
            $oModelAffiliate = new Affiliate();
            $oAffiliate = $oModelAffiliate::find()->where(array('code' => $referral))->one();
            $isAffiliate = ($oAffiliate) ?  TRUE : FALSE;
        }

        $sRerralUrl = (!empty($isAffiliate)) ? 'online-application/' . $referral : 'online-application';

        return $this->render('index',[
            'model' => $model,
            'vehicles' => $vehicles,
            'content' => $content,
            'referralUrl' => Yii::$app->urlManager->createUrl($sRerralUrl),
        ]);
    }

    /**
     * display steps form
     *
     * @param null $referral
     *
     * @return string
     */
    public function actionVehicle($referral = null){
        $error = "";
        $model = new VehicleTypes();
        $pModel = new Provinces();
        $oModel = new Contact();
        $oPageModel = new Pages();
        $isAffiliate = FALSE;


        $provinces = $pModel::find(['is_active' => 1])->orderBy('name')->asArray()->all();
        $vehicle = (Yii::$app->request->post('vehicle')) ? Yii::$app->request->post('vehicle') : 'sedan';
        $vType = $model::find()->where(array('keyword' => $vehicle))->one();
        $content = $oPageModel::find(['is_active' => 1])->asArray()->all();
        foreach($content as $v){
            $content[$v['keyword']] = $v['description'];
        }

        if (!empty($referral)) {
            $oModelAffiliate = new Affiliate();
            $oAffiliate = $oModelAffiliate::find()->where(array('code' => $referral))->one();
            $isAffiliate = ($oAffiliate) ? TRUE : FALSE;
        }

        return $this->render('steps', [
            'error'   => $error,
            'vehicle' => $vType['id'],
            'provinces' => $provinces,
            'model' => $model,
            'oModel' => $oModel,
            'content' => $content,
            'referral' => ($isAffiliate) ? $referral : '',
        ]);
    }

    /**
     * save first step of application
     * @return array
     */
    public function actionSaveStep(){
        $model = new Contact();
        $aImputs = array( 'vehicle_type_id', 'first_name', 'last_name', 'email', 'phone', 'month_of_birth', 'day_of_birth', 'year_of_birth', 'status');
        $referral = Yii::$app->request->post('referral');
        $response = array('type' => 'error', 'msg' => "Something went wrong please try again.");

        if ($model->load(Yii::$app->request->post()) && $model->validate($aImputs)) {
            if($model->save(true, $aImputs)){
                if (!empty($referral)) {
                    $modelAffiliate = new Affiliate();
                    $oAffiliate = $modelAffiliate::find()->where(array('code' => $referral))->one();
                    if (!empty($oAffiliate)) {
                        $modelAffiliateTransaction = new AffiliateTransaction();
                        $modelAffiliateTransaction->affiliateid = $oAffiliate['affiliate_id'];
                        $modelAffiliateTransaction->contactinfoid = $model->id;
                        $modelAffiliateTransaction->description = '1';
                        $modelAffiliateTransaction->amount = 0;
                        $modelAffiliateTransaction->dateadded = date("Y-m-d H:i:s");
                        $modelAffiliateTransaction->status = 3;
                        $modelAffiliateTransaction->save();
                    }
                }
                $response = array('type' => 'success', 'id' => $model->id);
            } else {
                $response = array('type' => 'error', 'msg' => "iaca aici.");
            }
        }
        else {
            $errors = $model->errors;
            $msg = 'Please check all inputs to fix the error: ' . PHP_EOL;
            if (!empty($errors)) {
                foreach ($errors as $k => $v) {
                    $msg .= $v[0] . PHP_EOL;
                }
            } else{
                $response = array('type' => 'error', 'msg' => "deamu aici.");
            }
            $response = array('type' => 'error', 'msg' => $msg);
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }

    /**
     * update the application data
     * @return array
     */
    public function actionFinish(){

        $nContactId = Yii::$app->request->post('app_id');
        $response = array('type' => 'error', 'msg' => "Can't save your application because of a technical error.");

        if(!empty($nContactId)){
            $modelContact = Contact::findOne($nContactId);
            $oPageModel = new Pages();
            $content = $oPageModel::find()->where(array('keyword' => 'step_f_inf'))->one();

            if($modelContact->load(Yii::$app->request->post())) {
                if($modelContact->save()){
                    $subject = "New application was created.";

                    $headers = "From: " . strip_tags(Yii::$app->request->post('email')) . PHP_EOL;
                    $headers .= "MIME-Version: 1.0" . PHP_EOL;
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1" . PHP_EOL;

                    $message = "Hello, " . PHP_EOL;
                    $message .= $this->renderPartial('email/application', array('model' => $modelContact));

                    @mail(Yii::$app->params['adminEmail'], $subject, $message, $headers);

                    $msg = $this->renderPartial('order_thanks_message', array('content' => $content));
                    $response = array('type' => 'success', 'msg' => $msg);
                }
            }
            else {
                $errors = $modelContact->errors;
                $msg = 'Please check all inputs to fix the error: ' . PHP_EOL;
                if (!empty($errors)) {
                    foreach ($errors as $k => $v) {
                        $msg .= $v[0] . PHP_EOL;
                    }
                }
                $response = array('type' => 'error', 'msg' => $msg);
            }
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }

    /**
     * validate form inputs
     * @return bool
     */
    public function actionValidate(){
        $model = new Contact();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return TRUE;
        }
        else {
            return false;
        }
    }

    /**
     * @return string|\yii\web\Response
     */
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

    /**
     * @return string|\yii\web\Response
     */
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
