<?php
/*
 *@ClassName: SearchInterface
 *@Description: 搜索组件接口
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-25 11:35:24
 *@LastEditors: 
 *@LastEditTime: 
*/

namespace backend\models\search;

interface SearchInterface
{
    public function search(array $params = [], array $options = []);
}

