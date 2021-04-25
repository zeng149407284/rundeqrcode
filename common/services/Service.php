<?php
/*
 *@ClassName: Service
 *@Description: 服务组件
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-25 11:29:24
 *@LastEditors: 
 *@LastEditTime: 
*/

namespace common\services;

use backend\models\search\SearchInterface;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

abstract class Service extends BaseObject implements ServiceInterface
{
    abstract public function getSearchModel(array $options = []);
    abstract public function getModel($id,array $options = []);
    abstract public function newModel(array $options = []);

    /*
     *@Description: 获得后端列表
     *@Param: $query
     *@Param: $options
     *@return: array|Exception
     *@Author: zenglinbo
    */
    public function getList(array $query = [], array $options = [])
    {
        $searchModel = $this->getSearchModel($options);
        if ($searchModel === null) {
            /** @var ActiveRecord $model */
            $model = $this->newModel();
            $result = [
                'dataProvider' => new ActiveDataFilter([
                    'query' => $model->find(),
                ]),
            ];
        }else if ($searchModel instanceof SearchInterface) {
            $dataProvider = $searchModel->search($query,$options);
            $result = [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ];
        }else {
            throw new Exception("getSearchModel must return null or backend\models\search\SearchInterface");  
        }
        return $result;
    }

    /*
     *@Description: 通过主键获取表数据(通常是主键‘id’)
     *@Param: $id
     *@Param: $options
     *@return: ActiveRecord|NotFoundHttpException
     *@Author: zenglinbo
    */
    public function getDetail($id, array $options = [])
    {
        /** @var ActiveRecord $model */
        $model = $this->getModel($id, $options);
        if (empty($model)) {
            throw new NotFoundHttpException("Record " . $id . " not exists");
        }
        return $model;
    }

    /*
     *@Description: 新建一条记录
     *@Param: $postData
     *@Param: $options
     *@return: ActiveRecord|bool
     *@Author: zenglinbo
    */
    public function create(array $postData, array $options = [])
    {
        /** @var ActiveRecord $model */
        $model = $this->newModel($options);
        if ($model->load($postData) && $model->save()) {
            return true;
        }
        return $model;
    }

    /*
     *@Description: 修改一条记录
     *@Param: $id
     *@Param: $postData
     *@Param: $options
     *@return: bool|ActiveRecord
     *@Author: zenglinbo
    */
    public function update($id, array $postData, array $options = [])
    {
        /** @var ActiveRecord $model */
        $model = $this->getModel($id, $options);
        if (empty($model)) {
            throw new NotFoundHttpException("Record " . $id . " not exists");
        }
        if ($model->load($postData) && $model->save()) {
            return true;
        }
        return $model;
    }

    /*
     *@Description: 删除一条记录
     *@Param: $id
     *@Param: $options
     *@return: ActiveRecord|bool|Exception
     *@Author: zenglinbo
    */
    public function delete($id, array $options = [])
    {
        /** @var ActiveRecord @model */
        $model = $this->getModel($id, $options);
        if (empty($model)) {
            throw new NotFoundHttpException("Record " . $id . " not exists");
        }
        $result = $model->delete();
        if ($result) {
            return true;
        }
        return $model;
    }

    /*
     *@Description: 修改表的排序
     *@Param: $id
     *@Param: $sort
     *@Param: $options
     *@return: string|bool|ActiveRecord
     *@Author: zenglinbo
    */
    public function sort($id, $sort, array $options = [])
    {
        $sortField = "sort";
        if (isset($options['sortField']) && !empty($options['sortField'])) {
            $sortField = $options['sortField'];
        }

        /** @var ActiveRecord $model */
        $model = $this->getModel($id, $options);
        if (empty($model)) {
            return "Id" . $id . " not exists";
        }
        $model->$sortField = $sort;
        $result = $model->save();
        if ($result) {
            return true;
        }
        return $model;
    }
}

