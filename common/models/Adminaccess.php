<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "adminaccess".
 *
 * @property integer $accessid
 * @property integer $ugid
 * @property integer $fuid
 */
class Adminaccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adminaccess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ugid', 'fuid'], 'required'],
            [['ugid', 'fuid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'accessid' => 'Accessid',
            'ugid' => 'Ugid',
            'fuid' => 'Fuid',
        ];
    }
}
