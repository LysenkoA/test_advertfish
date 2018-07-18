<?php

use yii\db\Migration;

/**
 * Class m180718_103757_rel_news_author
 */
class m180718_103757_rel_news_author extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rel_news_author}}', [
            'news_id' => $this->integer(),
            'author_id' => $this->integer(),
            'PRIMARY KEY(news_id, author_id)'
        ], $tableOptions);

        $this->createIndex(
            'idx-rel_news_author-news_id',
            'rel_news_author',
            'news_id'
        );

        $this->addForeignKey(
            'fk-rel_news_author-news_id',
            'rel_news_author',
            'news_id',
            'news',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-rel_news_author-author_id',
            'rel_news_author',
            'author_id'
        );

        $this->addForeignKey(
            'fk-rel_news_author-author_id',
            'rel_news_author',
            'author_id',
            'author',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-rel_news_author-author_id',
            'rel_news_author'
        );

        $this->dropIndex(
            'idx-rel_news_author-author_id',
            'rel_news_author'
        );

        $this->dropForeignKey(
            'fk-rel_news_author-news_id',
            'rel_news_author'
        );

        $this->dropIndex(
            'idx-rel_news_author-news_id',
            'rel_news_author'
        );

        $this->dropTable('{{%rel_news_author}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180718_103757_rel_news_author cannot be reverted.\n";

        return false;
    }
    */
}
