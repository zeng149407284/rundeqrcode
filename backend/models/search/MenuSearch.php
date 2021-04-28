<?php

namespace app\models\search
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Menu;

/**
 * MenuSearch represents the model behind the search form about 'common\models\Menu'.
 */
class MenuSearch extends Menu implements \backend\models\search\SearchInterface
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'parent_id', 'is_absolute_url', 'is_display', 'created_at', 'updated_at'], 'integer'],
        [['name', 'url', 'icon', 'target'], 'safe'],
        [['sort'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        //bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     *@param array $params
     *
     *@return ActiveDataProvider
     */
    public function search(array $params = [], array $options = [])
    {
        $query = Menu::find();

        //add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate())
        {
            //uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }

        //grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'parent_id' => $this->parent_id,
            'sort' => $this->sort,
            'is_absolute_url' => $this->is_absolute_url,
            'is_display' => $this->is_display,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'target', $this->target]);

        return $dataProvider;
    }
}

