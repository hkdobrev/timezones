<?php

use Phinx\Migration\AbstractMigration;

class InsertSampleTimezone extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute(
            'INSERT INTO `timezone` (
                `name`,
                `user_id`,
                `city`,
                `utc_offset`
            ) VALUES (
                "EEST",
                1,
                "Sofia",
                2
            )'
        );
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute(
            'TRUNCATE `timezone`'
        );
    }
}
