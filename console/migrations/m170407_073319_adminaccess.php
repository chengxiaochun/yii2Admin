<?php

use yii\db\Migration;

class m170407_073319_adminaccess extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%adminaccess}}', [
            'accessid' => 'int(11) NOT NULL AUTO_INCREMENT',
            'ugid' => 'smallint(6) unsigned NOT NULL COMMENT \'用户组\'',
            'fuid' => 'smallint(6) unsigned NOT NULL COMMENT \'功能\'',
            'PRIMARY KEY (`accessid`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员权限表'");
        
        /* 索引设置 */
        $this->createIndex('funcspk','{{%adminaccess}}','fuid',0);
        $this->createIndex('grppk','{{%adminaccess}}','ugid',0);
        
        
        /* 表数据 */
        $this->insert('{{%adminaccess}}',['accessid'=>'245','ugid'=>'2','fuid'=>'1']);
        $this->insert('{{%adminaccess}}',['accessid'=>'246','ugid'=>'2','fuid'=>'4']);
        $this->insert('{{%adminaccess}}',['accessid'=>'247','ugid'=>'2','fuid'=>'9']);
        $this->insert('{{%adminaccess}}',['accessid'=>'248','ugid'=>'2','fuid'=>'15']);
        $this->insert('{{%adminaccess}}',['accessid'=>'249','ugid'=>'2','fuid'=>'16']);
        $this->insert('{{%adminaccess}}',['accessid'=>'250','ugid'=>'2','fuid'=>'17']);
        $this->insert('{{%adminaccess}}',['accessid'=>'251','ugid'=>'2','fuid'=>'18']);
        $this->insert('{{%adminaccess}}',['accessid'=>'252','ugid'=>'2','fuid'=>'5']);
        $this->insert('{{%adminaccess}}',['accessid'=>'253','ugid'=>'2','fuid'=>'19']);
        $this->insert('{{%adminaccess}}',['accessid'=>'254','ugid'=>'2','fuid'=>'20']);
        $this->insert('{{%adminaccess}}',['accessid'=>'255','ugid'=>'2','fuid'=>'21']);
        $this->insert('{{%adminaccess}}',['accessid'=>'256','ugid'=>'2','fuid'=>'2']);
        $this->insert('{{%adminaccess}}',['accessid'=>'257','ugid'=>'2','fuid'=>'3']);
        $this->insert('{{%adminaccess}}',['accessid'=>'258','ugid'=>'2','fuid'=>'6']);
        $this->insert('{{%adminaccess}}',['accessid'=>'259','ugid'=>'2','fuid'=>'7']);
        $this->insert('{{%adminaccess}}',['accessid'=>'260','ugid'=>'2','fuid'=>'8']);
        $this->insert('{{%adminaccess}}',['accessid'=>'261','ugid'=>'2','fuid'=>'10']);
        $this->insert('{{%adminaccess}}',['accessid'=>'262','ugid'=>'2','fuid'=>'11']);
        $this->insert('{{%adminaccess}}',['accessid'=>'263','ugid'=>'2','fuid'=>'12']);
        $this->insert('{{%adminaccess}}',['accessid'=>'264','ugid'=>'2','fuid'=>'13']);
        $this->insert('{{%adminaccess}}',['accessid'=>'265','ugid'=>'2','fuid'=>'14']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%adminaccess}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

