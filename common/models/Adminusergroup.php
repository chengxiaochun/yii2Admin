<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "adminusergroup".
 *
 * @property integer $ugid
 * @property string $typename
 * @property integer $ugfatherid
 * @property integer $isDelete
 */
class Adminusergroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adminusergroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ugfatherid', 'isDelete'], 'integer'],
            [['typename'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ugid' => 'Ugid',
            'typename' => 'Typename',
            'ugfatherid' => 'Ugfatherid',
            'isDelete' => 'Is Delete',
        ];
    }
}
