<?php
    namespace common\components;

    use yii\base\Component;
    use app\models\Statistic;

    class CustomComponent extends Component{
        const EVENT_AFTER = "event-after";

        public function addToStatistic($request){
            // $model = new Statistic();
    
            // $userHost = $request->userHost;
            // $userIP = $request->userIP;
            // $path = $request->pathInfo;
            // $querystring = $request->queryString;
            // $time = date('Y-m-d H:i:s');
    
            // $model['access_time'] = $time;
            // $model['user_ip'] = $userIP;
            // $model['user_host'] = $_SERVER['REMOTE_ADDR'];
            // $model['path_info'] = $path;
            // $model['query_string'] = $querystring;
    
            // $model->save(false);
            $param = \Yii::$app->request;

            $statistic = new Statistic();
            $statistic->access_time = date('Y-m-d H:i:s');
            $statistic->user_ip = $param->userIP;
            $statistic->user_host = $param->userHost;
            $statistic->path_info = $param->pathInfo;
            $statistic->query_string = $param->queryString;

            $statistic->save();
        }
    }