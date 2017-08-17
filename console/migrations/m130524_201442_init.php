<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{

    use \common\traits\MigrationTrait;

    /**
     * @var string 用户表
     */
    public $tableName = '{{%user}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment('用户名'),
            'real_name' => $this->string()->notNull()->comment('真实姓名'),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique()->comment('邮箱'),

            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态 0停用 10正常'),
            'role' => $this->smallInteger()->notNull()->defaultValue(10)->comment('10普通用户 20管理员 30超级管理员'),
            'created_at' => $this->integer()->notNull()->defaultValue(null),
            'updated_at' => $this->integer()->notNull()->defaultValue(null),
        ], $this->getTableOptions());

        $this->addCommentOnTable($this->tableName, '用户表');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
