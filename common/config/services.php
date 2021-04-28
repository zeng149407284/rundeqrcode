<?php
/*
 *@ClassName: services.php
 *@Description: 服务类地址
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-28 19:09:03
 *@LastEditors: 
 *@LastEditTime: 
*/
return [
    \common\services\MenuServiceInterface::ServiceName => [
        'class' => \common\services\MenuService::className(),
    ],
];