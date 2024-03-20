<?php

use yii\db\Migration;

/**
 * Class m240309_204252_modify_user_table
 */
class m240309_204252_modify_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('
            ALTER TABLE "user" ADD COLUMN image varchar;
        ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240309_204252_modify_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240309_204252_modify_user_table cannot be reverted.\n";

        return false;
    }
    */
}
