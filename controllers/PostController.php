<?php /** @noinspection PhpUndefinedClassInspection */

namespace app\controllers;

use app\models\Comment;
use Throwable;
use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\ConflictHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\log\Logger;
use yii\web\Response;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\ExitException
     */
    public function actionView($id)
    {
        $post = $this->findModel($id);
        /** @var Post $post */
        $comment = $this->newComment($post);

        return $this->render('view', [
            'model' => $post,
            'comment' => $comment,
        ]);
    }


    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->request->isPost) {
            // we only allow deletion via POST request
            $this->findModel($id)->delete();
            if (!Yii::$app->request->isAjax)
                $this->redirect(array('admin'));
        } else
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.', 404);
        return $this->redirect(array('admin'));
//        return $this->redirect(['view', 'id' => $id]);
    }

    private $_model;

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ($this->_model === null) {
            if (isset($id)) {
                if (Yii::$app->user->isGuest) {
                    $condition = 'status='
                        . Post::STATUS_PUBLISHED
                        . ' OR status='
                        . Post::STATUS_ARCHIVED;
                } else {
                    $condition = '';
                }
                $this->_model = Post::find()->where(['id' => $id])->onCondition($condition)->one();
            }
            if ($this->_model === null)
                throw new NotFoundHttpException('Запрашиваемая страница не существует');
        }
        return $this->_model;
    }

    /**
     * @param $post Post
     * @return Comment|array
     * @throws \yii\base\ExitException
     */
    protected function newComment($post)
    {
        $comment = new Comment();
        $request = Yii::$app->request->post();
        if (isset($request['ajax']) && $request['ajax'] === 'comment-form') {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($comment);
            Yii::$app->end();
        }
        if (isset ($request['Comment'])) {
            $comment->attributes = $request['Comment'];
            if ($post->addComment($comment)) {
                if ($comment->status == Comment::STATUS_PENDING)
                    Yii::$app->session->setFlash('commentSubmitted', 'Thank you for your comment. Your comment will be posted once it is approved.');
                $this->refresh();
            }
        }
        return $comment;
    }
}
