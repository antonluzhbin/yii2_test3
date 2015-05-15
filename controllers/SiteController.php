<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Book;
use app\models\Reader;
use app\models\Author;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionBook($sort = null, $order = null, $filter = null)
    {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $filterstr = NULL;
        if ($filter)
        {
            $filterstr = $filter;
            $tmp = explode('|', $filter);
            $filter = Array();
            $filter['author'] = $tmp[0];
            $filter['name'] = $tmp[1];
            $filter['date_begin'] = $tmp[2];
            $filter['date_end'] = $tmp[3];
            $filter = (object) $filter;
        }
        
        $book = new Book;
        $data = $book->getAll($sort, $order, $filter);
        
        $author = new Author();
        $authorData = $author -> getData();
    
        return $this->render('book', array(
            'data' => $data,
            'sort' => $sort,
            'order' => $order,
            'author' => $authorData,
            'filter' => $filter,
            'filterstr' => $filterstr
        ));
    }
    
    public function actionShowbook($id = NULL)
    {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        if ($id === NULL)
            throw new HttpException(404, 'Not Found');

        $model = Book::find()->where(['id' => $id])->one();

        if ($model === NULL)
            throw new HttpException(404, 'Document Does Not Exist');
        
        $author = new Author();
        $authorData = $author -> getData();

        echo $this->renderAjax('viewbook', array(
            'model' => $model,
            'author' => $authorData
        ));
    }
           
    public function actionUpdatebook($id = NULL, $sort = null, $order = null, $filter = null)
    {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        if ($id === NULL)
            throw new HttpException(404, 'Not Found');

        $model = Book::find()->where(['id' => $id])->one();

        if ($model === NULL)
            throw new HttpException(404, 'Document Does Not Exist');

        if (isset($_POST['Book']))
        {
            $model->name = $_POST['Book']['name'];
            $model->preview = $_POST['Book']['preview'];
            $model->date = $_POST['Book']['date'];
            $model->author_id = $_POST['Book']['author_id'];

            if ($model->save())
            {
                Yii::$app->response->redirect(array('site/book', 'id' => $model->id, 'filter' => $filter, 'sort' => $sort, 'order' => $order));
                return;
            }
        }
        
        $author = new Author();
        $authorData = $author -> getData();

        echo $this->render('createbook', array(
            'model' => $model,
            'author' => $authorData,
            'sort' => $sort,
            'order' => $order,
            'filter' => $filter
        ));
    }
    
    public function actionDeletebook($id=NULL)
    {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        if ($id === NULL)
        {
            Yii::$app->session->setFlash('BookDeletedError');
            Yii::$app->getResponse()->redirect(array('site/book'));
        }

        $book = Book::find()->where(['id' => $id])->one();

        if ($book === NULL)
        {
            Yii::$app->session->setFlash('BookDeletedError');
            Yii::$app->getResponse()->redirect(array('site/book'));
        }

        $book->delete();

        Yii::$app->session->setFlash('BookDeleted');
        Yii::$app->getResponse()->redirect(array('site/book'));
    }
}
