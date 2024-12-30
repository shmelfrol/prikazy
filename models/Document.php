<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prikaz".
 *
 * @property int $id
 * @property int|null $numc
 * @property string $text
 * @property string $filename
 * @property int|null $index_id
 * @property int $created_at
 * @property int $created_by
 * @property int $reldate
 * @property string $oldfilename
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property string|null $edit_info
 * @property bool|null $is_del
 * @property int|null $action_id
 * @property int|null $modified_by_p_id
 *
 * @property Favorite[] $favorites
 * @property ModifiedPrikazes[] $modifiedPrikazes
 * @property ModifiedPrikazes[] $modifiedPrikazes0
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $symbol;
    public $prikaz_id;
    public $status_name;
    public $color;


    public static function tableName()
    {
        return 'prikaz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numc', 'index_id', 'created_at', 'created_by', 'reldate', 'updated_by', 'updated_at', 'action_id', 'modified_by_p_id'], 'default', 'value' => null],
            [['numc', 'index_id', 'created_at', 'created_by', 'reldate', 'updated_by', 'updated_at', 'action_id', 'modified_by_p_id'], 'integer'],
            [['text', 'filename', 'created_at', 'created_by', 'reldate', 'oldfilename'], 'required'],
            [['text', 'filename', 'oldfilename', 'edit_info'], 'string'],
            [['is_del'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numc' => 'Numc',
            'text' => 'Text',
            'filename' => 'Filename',
            'index_id' => 'Index ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'reldate' => 'Reldate',
            'oldfilename' => 'Oldfilename',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'edit_info' => 'Edit Info',
            'is_del' => 'Is Del',
            'action_id' => 'Action ID',
            'modified_by_p_id' => 'Modified By P ID',
        ];
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::class, ['prikaz_id' => 'id']);
    }

    /**
     * Gets query for [[ModifiedPrikazes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedPrikazes()
    {
        return $this->hasMany(ModifiedPrikazes::class, ['prikaz_id' => 'id']);
    }

    /**
     * Gets query for [[ModifiedPrikazes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedPrikazes0()
    {
        return $this->hasMany(ModifiedPrikazes::class, ['modified_prikaz_id' => 'id']);
    }
}
