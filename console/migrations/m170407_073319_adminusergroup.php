<?php

use yii\db\Migration;

class m170407_073319_adminusergroup extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%adminusergroup}}', [
            'ugid' => 'smallint(6) NOT NULL AUTO_INCREMENT',
            'typename' => 'varchar(255) NULL COMMENT \'分组名\'',
            'ugfatherid' => 'smallint(6) unsigned NULL DEFAULT \'0\' COMMENT \'父组id,0表示无父组\'',
            'isDelete' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'1:删除 0：不删除\'',
            'PRIMARY KEY (`ugid`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员用户组'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%adminusergroup}}',['ugid'=>'1','typename'=>'系统管理员','ugfatherid'=>'0','isDelete'=>'0']);
        $this->insert('{{%adminusergroup}}',['ugid'=>'2','typename'=>'超级管理员','ugfatherid'=>'1','isDelete'=>'0']);
        $this->insert('{{%adminusergroup}}',['ugid'=>'3','typename'=>'普通管理员','ugfatherid'=>'1','isDelete'=>'0']);
        $this->insert('{{%adminusergroup}}',['ugid'=>'4','typename'=>'销售组','ugfatherid'=>'0','isDelete'=>'0']);
        $this->insert('{{%adminusergroup}}',['ugid'=>'5','typename'=>'sale1','ugfatherid'=>'4','isDelete'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%adminusergroup}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

