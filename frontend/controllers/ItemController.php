<?php

namespace frontend\controllers;

use Yii;
use app\models\Statistic;
use app\models\item;
use app\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for item model.
 */
class ItemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all item models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->CustomComponent->trigger(\common\components\CustomComponent::EVENT_AFTER);
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $this->addToStatistic(Yii::$app->request);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    // public function actionIndex()
    // {
    //     // Yii::$app->CustomComponent->trigger(\common\components\CustomComponent::EVENT_AFTER);
    //     $request = Yii::$app->request;
    //     $this->addToStatistic($request);

    //     $searchModel = new ItemSearch();
    //     $userHost = Yii::$app->request->userHost;
    //     $userIP = Yii::$app->request->userIP;
    //     $path = Yii::$app->request->pathInfo;
    //     $querystring = Yii::$app->request->queryString;
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //     $time = date('Y-m-d H:i:s');

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //         'ip' => $userIP,
    //         'host' => $userHost,
    //         'path' => $path,
    //         'query' => $querystring,
    //         'time' => $time,
    //     ]);
    // }

    /**
     * Displays a single item model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //     $request = Yii::$app->request;
    //     $this->addToStatistic($request);
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new item();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Updates an existing item model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Deletes an existing item model.
    //  * If deletion is successful, the browser will be redirected to the 'index' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // public function addToStatistic($request){
    //     $model = new Statistic();

    //     $userHost = $request->userHost;
    //     $userIP = $request->userIP;
    //     $path = $request->pathInfo;
    //     $querystring = $request->queryString;
    //     $time = date('Y-m-d H:i:s');

    //     $model['access_time'] = $time;
    //     $model['user_ip'] = $userIP;
    //     $model['user_host'] = $_SERVER['REMOTE_ADDR'];
    //     $model['path_info'] = $path;
    //     $model['query_string'] = $querystring;

    //     $model->save(false);
    // }

    private function addToStatistic($param)
    {
        $statistic = new Statistic();
        $statistic->access_time = date('Y-m-d H:i:s');
        $statistic->user_ip = $param->userIP;
        $statistic->user_host = $param->userHost;
        $statistic->path_info = $param->pathInfo;
        $statistic->query_string = $param->queryString;

        $statistic->save();
    }
}
