<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DocumentSearch represents the model behind the search form of `app\models\Document`.
 */
class DocumentSearch extends Document
{
    public $year;
    public $month;

    /**
     * {@inheritdoc}
     */


    public function rules()
    {
        return [
            [['id', 'numc', 'index_id', 'created_at', 'created_by', 'reldate', 'updated_by', 'updated_at', 'action_id', 'modified_by_p_id', 'year', 'month'], 'integer'],
            [['text', 'filename', 'oldfilename', 'edit_info'], 'safe'],
            [['is_del'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $user_id = Yii::$app->user->identity->getId();
        $subQFav = Favorite::find()->where(['user_id' => $user_id]);
        $query = Prikaz::find()
            ->select([
                'prikaz.*',
                'fav.prikaz_id',
                "COALESCE(pi.symbol, '') as symbol",
                "COALESCE(status.status_name, '') as status_name",
                "COALESCE(status.color, '') as color",
            ])
            ->leftJoin(['pi' => "prikazindex"], 'pi.id=prikaz.index_id')
            ->leftJoin(['fav' => $subQFav], 'fav.prikaz_id=prikaz.id')
            ->leftJoin(['status' => "prikaz_action_type"], 'status.id=prikaz.action_id')
            ->orderBy('id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $y1 = $this->year;
        $y2 = $this->year;
        $month1 = $this->month;
        $month2 = $this->month;

        if ($this->month === null) {
            $this->month = '99';
        }

        if ($this->year == null) {
            $y1 = Date('Y');
            $y2 = Date('Y');
        }
        if ($this->month == '99') {
            $month1 = '01';
            $month2 = '12';
        }

        if ($this->year === '9999') {
            $y1 = '2000';
            $y2 = Date('Y');
            $month1 = '01';
            $month2 = '12';
        }

        $number = cal_days_in_month(CAL_GREGORIAN, $month2, $y2);
        $date1 = $y1 . "-" . $month1 . "-" . "01";
        $date2 = $y2 . "-" . $month2 . "-" . $number;
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'numc' => $this->numc,
            'index_id' => $this->index_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'reldate' => $this->reldate,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'is_del' => $this->is_del,
            'action_id' => $this->action_id,
            'modified_by_p_id' => $this->modified_by_p_id,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text])
            ->andFilterWhere(['ilike', 'filename', $this->filename])
            ->andFilterWhere(['ilike', 'oldfilename', $this->oldfilename])
            ->andFilterWhere(['ilike', 'edit_info', $this->edit_info])
            ->andWhere(['between', 'reldate', $date1, $date2]);

        return $dataProvider;
    }
}
