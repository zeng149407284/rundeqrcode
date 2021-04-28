<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rd_menu".
 *
 * @property int $id 主键ID
 * @property int $type 菜单类型(0 backend, 1 frontend
 * @property int $parent_id 父菜单ID
 * @property string $name 菜单名
 * @property string $url 菜单路由
 * @property string $icon 菜单图标
 * @property float $sort 菜单序号
 * @property string $target 打开方式(_blank, _self
 * @property int $is_absolute_url 是否绝对路由
 * @property int $is_display 是否显示(0 no, 1 yes
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rd_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'parent_id', 'is_absolute_url', 'is_display', 'created_at', 'updated_at'], 'integer'],
            [['name', 'url', 'created_at'], 'required'],
            [['sort'], 'number'],
            [['name', 'url', 'icon', 'target'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'url' => 'Url',
            'icon' => 'Icon',
            'sort' => 'Sort',
            'target' => 'Target',
            'is_absolute_url' => 'Is Absolute Url',
            'is_display' => 'Is Display',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
