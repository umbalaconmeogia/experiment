<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Auth;
use app\models\User;

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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
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
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Callback when "auth" success.
     * @param yii\authclient\ClientInterface $client
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        // Check if Google authentication registered.
        /** @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) { // If not logged in
            $user = NULL;
            if ($auth) { // If Google account registered, then login corresponding user.
                $user = $auth->user;
            } else { // Signup a user with this Google account.
                $email = $this->getGoogleUserEmail($attributes);
                if (User::find()->where(['email' => $email])->exists()) {
                    $this->setFlashError(
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()])
                    );
                } else { // User not registered. Register it.
                    $transaction = User::getDb()->beginTransaction();
                    try {
                        // Register user with Google account.
                        $user = new User([
                            'username' => $email,
                            'email' => $email,
                        ]);
                        if ($user->save()) {
                            if (!$this->createAuth($user->id, $client)) {
                                throw new \Exception(print_r($auth->getErrors(), TRUE));
                            }
                        } else {
                            throw new \Exception(print_r($user->getErrors(), TRUE));
                        }
                        $transaction->commit();
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        $this->setFlashError($e->getMessage());
                    }
                }
            }
            // Login user if success.
            if ($user) {
                Yii::$app->user->login($user);
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider if not registered.
                $this->createAuth(Yii::$app->user->id, $client);
            }
        }
    }

    /**
     * Create an Auth object, and save it into DB.
     * @param int $userId
     * @param yii\authclient\ClientInterface $client
     * @return boolean Result of Auth#save()
     */
    private function createAuth($userId, $client)
    {
        $auth = new Auth([
            'user_id' => $userId,
            'source' => $client->getId(),
            'source_id' => $client->getUserAttributes()['id'],
        ]);
        return $auth->save();
    }

    /**
     * @param string $message
     */
    private function setFlashError($message)
    {
        Yii::$app->getSession()->setFlash('error', $message);
    }

    /**
     * Get email from user attributes of Google Authentication client.
     * Google client return email in "emails" array.
     * @param array $attributes
     * @return string May be null if does not exist.
     */
    private function getGoogleUserEmail($attributes)
    {
        $result = NULL;
        if (isset($attributes['emails'])) {
            foreach ($attributes['emails'] as $email) {
                $result = $email['value'];
                break;
            }
        }
        return $result;
    }
}
