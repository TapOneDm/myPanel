<?php

use yii\db\Migration;

/**
 * Class m240311_200757_modify_user_table
 */
class m240311_200757_modify_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->execute('
//            ALTER TABLE "user" ADD COLUMN old_password varchar NULL;
//        ');
//
//        $this->execute('
//            ALTER TABLE "user" ADD COLUMN new_password varchar NULL;
//        ');
//
//        $this->execute('
//            ALTER TABLE "user" ADD COLUMN confirm_password varchar NULL;
//        ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240311_200757_modify_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240311_200757_modify_user_table cannot be reverted.\n";

        return false;
    }
    */
}
