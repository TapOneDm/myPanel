<?php

use yii\db\Migration;

/**
 * Class m240320_205511_add_tag_table
 */
class m240320_205511_add_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240320_205511_add_tag_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240320_205511_add_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
