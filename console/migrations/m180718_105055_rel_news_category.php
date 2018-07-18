<?php

use yii\db\Migration;

/**
 * Class m180718_105055_rel_news_category
 */
class m180718_105055_rel_news_category extends Migration
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

        $this->createTable('{{%rel_news_category}}', [
            'news_id' => $this->integer(),
            'category_id' => $this->integer(),
            'PRIMARY KEY(news_id, category_id)'
        ], $tableOptions);

        $this->createIndex(
            'idx-rel_news_category-news_id',
            'rel_news_category',
            'news_id'
        );

        $this->addForeignKey(
            'fk-rel_news_category-news_id',
            'rel_news_category',
            'news_id',
            'news',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-rel_news_category-category_id',
            'rel_news_category',
            'category_id'
        );

        $this->addForeignKey(
            'fk-rel_news_category-category_id',
            'rel_news_category',
            'category_id',
            'category',
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
            'fk-rel_news_category-category_id',
            'rel_news_category'
        );

        $this->dropIndex(
            'idx-rel_news_category-category_id',
            'rel_news_category'
        );

        $this->dropForeignKey(
            'fk-rel_news_category-news_id',
            'rel_news_category'
        );

        $this->dropIndex(
            'idx-rel_news_category-news_id',
            'rel_news_category'
        );

        $this->dropTable('{{%rel_news_category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180718_105055_rel_news_category cannot be reverted.\n";

        return false;
    }
    */
}
