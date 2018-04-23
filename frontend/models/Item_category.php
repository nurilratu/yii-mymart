<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_category".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_category
 *
 * @property Item[] $items
 */
class Item_category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'parent_category'], 'required'],
            [['id', 'parent_category'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_category' => 'Parent Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['category_id' => 'id']);
    }
}
