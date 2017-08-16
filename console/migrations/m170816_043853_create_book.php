<?php

use yii\db\Migration;

class m170816_043853_create_book extends Migration
{
    use \common\traits\MigrationTrait;

    /**
     * @var string 书籍
     */
    public $tableName = '{{%book}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('书名'),
            'author' => $this->string()->notNull()->comment('作者'),
            'own_user_id' => $this->integer()->notNull()->defaultValue(0)->comment('此书拥有者 0代表公司'),
            'borrow_user_id' => $this->integer()->notNull()->defaultValue(0)->comment('此书借阅者'),
            'image' => $this->string()->notNull()->comment('书籍封面'),
            'isbn' => $this->string(20)->notNull()->comment('ISBN 号'),
            'data' => $this->text()->notNull()->defaultValue(null)->comment('api json 数据'),

            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('状态：0无人借阅 1已经被借阅'),
            'created_at' => $this->integer()->notNull()->defaultValue(null),
            'updated_at' => $this->integer()->notNull()->defaultValue(null),
        ], $this->getTableOptions());

        $this->addCommentOnTable($this->tableName, '书籍表');
        $this->createIndex('idx_title', $this->tableName, 'title');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
