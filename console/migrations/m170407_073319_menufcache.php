<?php

use yii\db\Migration;

class m170407_073319_menufcache extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%menufcache}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='菜单片段缓存依赖'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%menufcache}}',['id'=>'10']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%menufcache}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

