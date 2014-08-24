<?php

use Phinx\Migration\AbstractMigration;

class AddIdToUsers extends AbstractMigration
{
    public function up()
    {
        $this->execute(
            'ALTER TABLE `oauth_users`
            ADD COLUMN `id` int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT FIRST'
        );
    }

    public function down()
    {
        $this->execute(
            'ALTER TABLE `oauth_users`
            CHANGE COLUMN `id` `id` INT(11) NOT NULL,
            DROP PRIMARY KEY'
        );

        $this->table('oauth_users')
            ->removeColumn('id')
            ->save();
    }
}
