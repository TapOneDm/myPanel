<?php

use yii\db\Migration;

/**
 * Class m240320_205424_add_blog_table
 */
class m240320_205424_add_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('
            create table "blog" (
                "id" bigserial NOT NULL,
                PRIMARY KEY ("id"),
                title varchar,
                url varchar,
                text text,
                status_id integer,
                sort_order integer NULL,
                user_id integer,
                created_at TIMESTAMPTZ,
                updated_at TIMESTAMPTZ,
                image varchar
            );
        ');

        $this->execute('
            create table "tag" (
                "id" bigserial NOT NULL,
                PRIMARY KEY ("id"),
                name varchar
            );
        ');

        $this->execute('ALTER TABLE "blog" ADD FOREIGN KEY ("user_id") REFERENCES "user" ("id")');

        $this->execute('
            CREATE TABLE "blog_tag" (
                "id" bigint NOT NULL,
                "blog_id" bigint NOT NULL,
                "tag_id" bigint NULL
            );
        ');

        $this->execute('ALTER TABLE "blog_tag" ADD CONSTRAINT "blog_id_tag_id" PRIMARY KEY ("blog_id", "tag_id");');
        $this->execute('ALTER TABLE "blog_tag" ADD FOREIGN KEY ("blog_id") REFERENCES "blog" ("id")');
        $this->execute('ALTER TABLE "blog_tag" ADD FOREIGN KEY ("tag_id") REFERENCES "tag" ("id")');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240320_205424_add_blog_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240320_205424_add_blog_table cannot be reverted.\n";

        return false;
    }
    */
}
