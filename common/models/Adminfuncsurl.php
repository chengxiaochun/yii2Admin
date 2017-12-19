<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "adminfuncsurl".
 *
 * @property integer $fuid
 * @property string $funame
 * @property string $fuURL
 * @property integer $fatherfuid
 * @property string $isShow
 * @property integer $isCheck
 * @property integer $isDelete
 * @property string $icon_class
 * @property string $sort
 */
class Adminfuncsurl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adminfuncsurl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fatherfuid', 'isShow', 'isCheck', 'isDelete', 'sort'], 'integer'],
            [['funame', 'fuURL'], 'string', 'max' => 255],
            [['icon_class'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fuid' => 'Fuid',
            'funame' => 'Funame',
            'fuURL' => 'Fu Url',
            'fatherfuid' => 'Fatherfuid',
            'isShow' => 'Is Show',
            'isCheck' => 'Is Check',
            'isDelete' => 'Is Delete',
            'icon_class' => 'Icon Class',
            'sort' => 'Sort',
        ];
    }
}
