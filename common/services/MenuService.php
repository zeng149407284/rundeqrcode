<?php

namespace common\services;

use app\models\search\MenuSearch;
use common\models\Menu;

class MenuService extends Service implements MenuServiceInterface
{
    public function getSearchModel(array $query = [], array $options = [])
    {
                    return new MenuSearch();
            }

    public function getModel($id, array $options = [])
    {
        return Menu::findOne($id);
    }

    public function newModel(array $options = [])
    {
        $model = new Menu();
        $model->loadDefaultValues();
        return $model;
    }
}

