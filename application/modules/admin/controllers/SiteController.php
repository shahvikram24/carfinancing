<?php
    namespace app\modules\admin\controllers;

    use app\models\ChangePasswordForm;
    use app\models\PasswordForm;
    use app\models\Provinces;
    use app\models\User;
    use Yii;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\filters\AccessControl;
    use app\models\LoginForm;

    /**
     * Site controller
     */
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
                    'rules' => [
                        [
                            'actions' => ['login', 'error'],
                            'allow'   => TRUE,
                        ],
                        [
                            'actions' => ['logout', 'index', 'changepassword', 'provinces'],
                            'allow'   => TRUE,
                            'roles'   => ['@'],
                        ],
                    ],
                ],
                'verbs'  => [
                    'class'   => VerbFilter::className(),
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
            ];
        }

        /**
         * Displays homepage.
         *
         * @return string
         */
        public function actionIndex()
        {

            return $this->render('index');
        }

        /**
         * Login action.
         *
         * @return string
         */
        public function actionLogin()
        {
            if (!Yii::$app->user->isGuest) {
                $this->redirect(Yii::$app->urlManager->createUrl('/admin/application'));
            }

            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $this->redirect(Yii::$app->urlManager->createUrl('/admin/application'));
            }
            else {
                $this->layout = 'auth';
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        }

        public function actionError(){
            $this->redirect(Yii::$app->urlManager->createUrl('home'));
        }

        public function actionChangepassword()
        {
            $id = Yii::$app->user->id;

            try {
                $model = new ChangePasswordForm($id);
            }
            catch (InvalidParamException $e) {
                throw new \yii\web\BadRequestHttpException($e->getMessage());
            }

            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
                Yii::$app->session->setFlash('success', 'Password Changed!');
                $success = "Password changed.";
            }

            return $this->render('changepassword', [
                'model' => $model,
                'success' => (!empty($success)) ? $success: '',
            ]);
        }



        public function actionProvinces(){
            $pModel = new Provinces();
            $oProvinces = $pModel::find(['is_active' => 1])->orderBy('name')->asArray()->all();

            return $this->render('provinces',
                array(
                    'provinces' => $oProvinces,
                    'model' => $pModel,
                ));
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
