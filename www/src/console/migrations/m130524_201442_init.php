<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->execute('drop table if exists "auth_assignment";');
        $this->execute('drop table if exists "auth_item_child";');
        $this->execute('drop table if exists "auth_item";');
        $this->execute('drop table if exists "auth_rule";');
        
        $this->execute('
            create table "auth_rule"
            (
                "name"  varchar(64) not null,
                "data"  bytea,
                "created_at"           integer,
                "updated_at"           integer,
                primary key ("name")
            );
        ');

        $this->execute('
            create table "auth_item"
            (
            "name"                 varchar(64) not null,
            "type"                 smallint not null,
            "description"          text,
            "rule_name"            varchar(64),
            "data"                 bytea,
            "created_at"           integer,
            "updated_at"           integer,
            primary key ("name"),
            foreign key ("rule_name") references "auth_rule" ("name") on delete set null on update cascade
            );
        ');

        $this->execute('create index auth_item_type_idx on "auth_item" ("type");');

        $this->execute('
            create table "auth_item_child"
            (
            "parent"               varchar(64) not null,
            "child"                varchar(64) not null,
            primary key ("parent","child"),
            foreign key ("parent") references "auth_item" ("name") on delete cascade on update cascade,
            foreign key ("child") references "auth_item" ("name") on delete cascade on update cascade
            );            
        ');

        $this->execute('
            create table "auth_assignment"
            (
            "item_name"            varchar(64) not null,
            "user_id"              varchar(64) not null,
            "created_at"           integer,
            primary key ("item_name","user_id"),
            foreign key ("item_name") references "auth_item" ("name") on delete cascade on update cascade
            );
        ');

        $this->execute('create index auth_assignment_user_id_idx on "auth_assignment" ("user_id");');

        
        $user = new \common\models\User();
        $user->username = env('ROOT_USER_USERNAME');
        $user->email = env('ROOT_USER_EMAIL');
        $user->setPassword(env('ROOT_USER_PASSWORD'));
        $user->permissions = ['123'];
        $user->auth_key = '';
        $user->status = \common\models\User::STATUS_ACTIVE;
        $user->save();
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
