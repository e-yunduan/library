<?php

use yii\db\Migration;

class m170816_050148_create_user_metadata extends Migration
{
    use \common\traits\MigrationTrait;

    /**
     * @var string 用户操作元数据
     */
    public $tableName = '{{%user_metadata}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->smallInteger()->notNull()->comment('类型：1借阅 2还书'),
            'book_id' => $this->integer()->notNull()->comment('书籍ID'),
            'created_at' => $this->integer()->notNull()->defaultValue(null),
        ], $this->getTableOptions());

        $this->addCommentOnTable($this->tableName, '用户操作元数据表');
        $this->createIndex('idx_user_id', $this->tableName, 'user_id');
        $this->createIndex('idx_book_id', $this->tableName, 'book_id');
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
