<?php

use Phinx\Migration\AbstractMigration;

class InsertLoginScopeAndMakeItDefault extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute(
            'UPDATE `oauth_scopes`
            SET `is_default` = 0'
        );

        $this->execute(
            'INSERT INTO `oauth_scopes` (
                `scope`, `is_default`
            ) VALUES (
                "login", 1
            )'
        );
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute(
            'UPDATE `oauth_scopes`
            SET `is_default` = 1'
        );

        $this->execute(
            'DELETE FROM `oauth_scopes`
            WHERE `scope` = "login"'
        );
    }
}
