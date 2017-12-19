<?php

use yii\db\Migration;

class m170407_073319_adminuser extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%adminuser}}', [
            'adminuserid' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'username' => 'varchar(255) NOT NULL COMMENT \'用户名\'',
            'access_token' => 'varchar(255) NULL COMMENT \'验证token\'',
            'token_time' => 'int(11) NULL COMMENT \'token过期时间戳\'',
            'allowance' => 'int(11) NOT NULL DEFAULT \'40\' COMMENT \'api允许访问的剩余次数\'',
            'allowance_updated_at' => 'int(11) NOT NULL DEFAULT \'0\'',
            'photo' => 'varchar(255) NOT NULL DEFAULT \'\' COMMENT \'头像地址\'',
            'password_hash' => 'varchar(255) NOT NULL COMMENT \'哈希密码\'',
            'mobilNo' => 'varchar(255) NOT NULL DEFAULT \'\' COMMENT \'手机\'',
            'ugid' => 'int(10) unsigned NOT NULL COMMENT \'用户组id\'',
            'userbasestate' => 'varchar(255) NOT NULL COMMENT \'状态 0正常 1冻结\'',
            'auth_key' => 'varchar(255) NOT NULL DEFAULT \'\'',
            'password_reset_token' => 'varchar(255) NULL',
            'status' => 'varchar(255) NOT NULL DEFAULT \'10\' COMMENT \'状态，0 删除 10激活\'',
            'created_at' => 'datetime NOT NULL  COMMENT \'生成时间\'',
            'updated_at' => 'datetime NOT NULL  COMMENT \'修改时间\'',
            'PRIMARY KEY (`adminuserid`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员用户'");
        
        /* 索引设置 */
        $this->createIndex('username','{{%adminuser}}','username',1);
        
        
        /* 表数据 */
        $this->insert('{{%adminuser}}',['adminuserid'=>'1','username'=>'admin','access_token'=>NULL,'token_time'=>NULL,'allowance'=>'40','allowance_updated_at'=>'0','photo'=>'','password_hash'=>'$2y$13$B3l7qYbxvHtgy/iXyfHkQOyzK2YYHyxgGPBOLMoZLtwQy6SvCAVMe','mobilNo'=>'','ugid'=>'2','userbasestate'=>'0','auth_key'=>'','password_reset_token'=>NULL,'status'=>'10','created_at'=>'2016-12-09 15:20:57','updated_at'=>'2017-02-13 15:49:02']);
        $this->insert('{{%adminuser}}',['adminuserid'=>'2','username'=>'test','access_token'=>NULL,'token_time'=>NULL,'allowance'=>'40','allowance_updated_at'=>'0','photo'=>'','password_hash'=>'$2y$13$fMou41ONRbe5Sk0cC1S.TeTtYtYDKg7uWKfLrrShjMm1p2uU/NpAO','mobilNo'=>'','ugid'=>'3','userbasestate'=>'0','auth_key'=>'','password_reset_token'=>NULL,'status'=>'10','created_at'=>'2017-02-14 08:00:00','updated_at'=>'2017-02-15 14:53:41']);
        $this->insert('{{%adminuser}}',['adminuserid'=>'3','username'=>'t1','access_token'=>NULL,'token_time'=>NULL,'allowance'=>'40','allowance_updated_at'=>'0','photo'=>'','password_hash'=>'$2y$13$Qzv6fqOWY6uGXU/AHF45DuwoDUO68idxspxfjVJG9ISjH02IsFdg.','mobilNo'=>'','ugid'=>'2','userbasestate'=>'0','auth_key'=>'','password_reset_token'=>NULL,'status'=>'10','created_at'=>'2017-02-14 07:00:00','updated_at'=>'2017-02-14 10:03:50']);
        $this->insert('{{%adminuser}}',['adminuserid'=>'4','username'=>'t2','access_token'=>NULL,'token_time'=>NULL,'allowance'=>'40','allowance_updated_at'=>'0','photo'=>'','password_hash'=>'$2y$13$xC.Ke/Ue0qM12QLN2PDaGOoeEdZf/zp5g70MfZZ3Y5hDiYfLRUwBK','mobilNo'=>'','ugid'=>'2','userbasestate'=>'0','auth_key'=>'','password_reset_token'=>NULL,'status'=>'10','created_at'=>'2017-02-14 10:01:43','updated_at'=>'2017-02-14 10:01:43']);
        $this->insert('{{%adminuser}}',['adminuserid'=>'5','username'=>'t3','access_token'=>NULL,'token_time'=>NULL,'allowance'=>'40','allowance_updated_at'=>'0','photo'=>'','password_hash'=>'$2y$13$732eJgSRyKLB6ZyFYSQFBuBnNTIpccRkMQCVcOfM9E1DZ0PuSHKEa','mobilNo'=>'','ugid'=>'2','userbasestate'=>'0','auth_key'=>'','password_reset_token'=>NULL,'status'=>'0','created_at'=>'2017-02-14 10:03:08','updated_at'=>'2017-02-15 15:34:09']);
        $this->insert('{{%adminuser}}',['adminuserid'=>'6','username'=>'t4','access_token'=>NULL,'token_time'=>NULL,'allowance'=>'40','allowance_updated_at'=>'0','photo'=>'','password_hash'=>'$2y$13$iXlLuDvDGKcPrd8JUWhXuu86kx.TGt4iwY91xcb9gcCxFOXgeCZ9O','mobilNo'=>'','ugid'=>'4','userbasestate'=>'1','auth_key'=>'','password_reset_token'=>NULL,'status'=>'10','created_at'=>'2017-02-14 16:40:40','updated_at'=>'2017-02-15 17:00:13']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%adminuser}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

