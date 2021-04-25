<?php
/*
 *@ClassName: 服务组件接口
 *@Description: ServiceInterface
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-25 10:20:52
 *@LastEditors: 
 *@LastEditTime: 
*/

namespace common\services;

interface ServiceInterface
{
    //后台列表页面
    public function getList(array $query = [], array $options = []);
    //通过主键得到一条表数据
    public function getModel($id, array $options = []);
    //得到搜索的表数据
    public function getSearchModel(array $options = []);
    //创建一条默认的新的表数据
    public function newModel(array $options = []);

    //传入数据，创建一条表数据
    public function create(array $postData, array $options = []);
    //修改表数据
    public function update($id, array $postData, array $options = []);
    //得到一条表数据，如果不存在，返回404异常
    public function getDetail($id, array $options = []);
    //删除一条数据
    public function delete($id, array $options = []);

    //修改表排序
    public function sort($id, $sort,array $options = []);
}
