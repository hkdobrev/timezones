<?php

use Phinx\Migration\AbstractMigration;

class AddScopeToOauthUsers extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->table('oauth_users')
            ->addColumn('scope', 'text', array(
                'null' => true,
            ))
            ->save();

        $this->execute(
            'UPDATE `oauth_users`
            SET `scope` = "login timezones"'
        );
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('oauth_users')
            ->removeColumn('scope')
            ->save();
    }
}
