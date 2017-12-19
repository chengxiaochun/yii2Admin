<?php

use yii\db\Migration;

class m170407_073319_adminfuncsurl extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%adminfuncsurl}}', [
            'fuid' => 'smallint(6) NOT NULL AUTO_INCREMENT',
            'funame' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'功能名\'',
            'fuURL' => 'varchar(255) NULL DEFAULT \'\' COMMENT \'功能url\'',
            'fatherfuid' => 'smallint(6) unsigned NULL DEFAULT \'0\' COMMENT \'父功能id\'',
            'isShow' => 'int(1) unsigned NOT NULL COMMENT \'0:不在功能导航栏显示 1：在功能导航栏显示\'',
            'isCheck' => 'tinyint(1) unsigned NOT NULL DEFAULT \'1\' COMMENT \'0：不检测权限 1：检测权限\'',
            'isDelete' => 'tinyint(3) unsigned NOT NULL DEFAULT \'0\' COMMENT \'0：不删除 1：删除\'',
            'icon_class' => 'varchar(30) NOT NULL DEFAULT \'glyphicon glyphicon-stop\' COMMENT \'功能图标\'',
            'sort' => 'int(10) unsigned NOT NULL COMMENT \'排序\'',
            'PRIMARY KEY (`fuid`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员功能表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'1','funame'=>'用户管理','fuURL'=>'','fatherfuid'=>'0','isShow'=>'1','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-user','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'2','funame'=>'系统管理','fuURL'=>'','fatherfuid'=>'0','isShow'=>'1','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-cog','sort'=>'1']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'3','funame'=>'功能列表','fuURL'=>'/sysmanage/adminfunclist','fatherfuid'=>'2','isShow'=>'1','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'4','funame'=>'管理员列表','fuURL'=>'/admin/adminlist','fatherfuid'=>'1','isShow'=>'1','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'5','funame'=>'用户列表','fuURL'=>'/usermanage/userlist','fatherfuid'=>'1','isShow'=>'1','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'6','funame'=>'添加功能','fuURL'=>'/sysmanage/addfunc','fatherfuid'=>'3','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'7','funame'=>'修改功能','fuURL'=>'/sysmanage/modifyfuncs','fatherfuid'=>'3','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'8','funame'=>'管理员授权','fuURL'=>'/sysmanage/adminauth','fatherfuid'=>'2','isShow'=>'1','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'9','funame'=>'添加管理员','fuURL'=>'/admin/addadmin','fatherfuid'=>'4','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'10','funame'=>'确定授权','fuURL'=>'/sysmanage/updatepower','fatherfuid'=>'8','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'11','funame'=>'后台用户组','fuURL'=>'/sysmanage/adminug','fatherfuid'=>'2','isShow'=>'1','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'12','funame'=>'修改后台用户组','fuURL'=>'/sysmanage/updateadminug','fatherfuid'=>'11','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'13','funame'=>'添加后台用户组','fuURL'=>'/sysmanage/addusergroup','fatherfuid'=>'11','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'14','funame'=>'删除用户组','fuURL'=>'/sysmanage/deleteadminug','fatherfuid'=>'11','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'15','funame'=>'修改密码','fuURL'=>'/admin/updatepw','fatherfuid'=>'4','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'16','funame'=>'修改分组','fuURL'=>'/admin/updateadminug','fatherfuid'=>'4','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'17','funame'=>'删除管理员','fuURL'=>'/admin/deladmin','fatherfuid'=>'4','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'18','funame'=>'编辑','fuURL'=>'/admin/editadmin','fatherfuid'=>'4','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'19','funame'=>'添加用户','fuURL'=>'/usermanage/adduser','fatherfuid'=>'5','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'20','funame'=>'编辑用户','fuURL'=>'/usermanage/edituser','fatherfuid'=>'5','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        $this->insert('{{%adminfuncsurl}}',['fuid'=>'21','funame'=>'修改密码','fuURL'=>'/usermanage/updatepw','fatherfuid'=>'5','isShow'=>'0','isCheck'=>'1','isDelete'=>'0','icon_class'=>'glyphicon glyphicon-stop','sort'=>'0']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%adminfuncsurl}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

