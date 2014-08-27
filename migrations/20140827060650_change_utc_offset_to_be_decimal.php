<?php

use Phinx\Migration\AbstractMigration;

class ChangeUtcOffsetToBeDecimal extends AbstractMigration
{
    public function up()
    {
        $this->execute(
            'ALTER TABLE `timezone`
            CHANGE COLUMN `utcOffset` `utcOffset` DECIMAL( 2, 1 ) NOT NULL'
        );
    }

    public function down()
    {
        $this->execute(
            'ALTER TABLE `timezone`
            CHANGE COLUMN `utcOffset` `utcOffset` INT( 11 ) NOT NULL'
        );
    }
}
