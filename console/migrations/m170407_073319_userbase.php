<?php

use yii\db\Migration;

class m170407_073319_userbase extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%userbase}}', [
            'userid' => 'int(11) NOT NULL AUTO_INCREMENT',
            'username' => 'varchar(255) NOT NULL',
            'auth_key' => 'varchar(32) NOT NULL DEFAULT \'\'',
            'password_hash' => 'varchar(255) NOT NULL DEFAULT \'\'',
            'password_reset_token' => 'varchar(255) NULL',
            'email' => 'varchar(255) NOT NULL DEFAULT \'\'',
            'status' => 'smallint(6) NOT NULL DEFAULT \'10\'',
            'created_at' => 'datetime NOT NULL ',
            'updated_at' => 'datetime NOT NULL ',
            'PRIMARY KEY (`userid`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('username','{{%userbase}}','username',1);
        $this->createIndex('password_reset_token','{{%userbase}}','password_reset_token',1);
        
        
        /* 表数据 */
        $this->insert('{{%userbase}}',['userid'=>'1','username'=>'user','auth_key'=>'','password_hash'=>'$2y$13$lJngsWVQ97pwrRli3Eabh.XVH8yo8y3yb.ybI6dRLIMAiHpCciox6','password_reset_token'=>NULL,'email'=>'502091417@qq.com','status'=>'10','created_at'=>'2017-04-07 14:47:56','updated_at'=>'2017-04-07 15:28:14']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%userbase}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

