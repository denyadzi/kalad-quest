<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\{Controller, HttpException};
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\{LoginForm, User, QuestTask, QuestForm};

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
                'except' => ['index', 'login', 'reset-password'],
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'quest' => ['get'],
                    'quest-check' => ['post'],
                    'quest-ajax-state' => ['get'],
                    'reset-password' => ['get'],
                    'login' => ['get', 'post'],
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

    public function actionQuest()
    {
        $task = QuestTask::findUnPassed();
        if ( ! $task) {
            return $this->render('complete');
        }
        $form = new QuestForm([
            'questTask' => $task
        ]);

        return $this->render('quest', [
            'model' => $form,
        ]);
    }

    public function actionQuestCheck($id)
    {
        $task = QuestTask::findOne($id);
        if ( ! $task) {
            throw new HttpException(404);
        }
        $form = new QuestForm([
            'questTask' => $task
        ]);
        if ($form->load(Yii::$app->request->post())
            && $form->validate()
            && $form->savePassed()
        ) {
            return $this->redirect(['/site/quest']);
        }

        return $this->render('quest', [
            'model' => $form,
        ]);
    }

    public function actionQuestAjaxState($id)
    {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $task = QuestTask::findOne($id);
        if ( ! $task) {
           $response->statusCode = 404; 
           return ['error' => true];
        }
        return ['error' => false, 'task_passed' => $task->passed];
    }

    public function actionResetPassword($token)
    {
        $decodedToken = base64_decode ($token);
        if ( ! User::isPasswordResetTokenValid($decodedToken)) {
            throw new HttpException(400);
        }

        $user = User::findByPasswordResetToken($decodedToken);
        if ( ! $user) {
            throw new HttpException(404);
        }
        $user->removePasswordResetToken();
        $user->save();
        Yii::$app->user->login($user);

        return $this->goHome();
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
}
