<?php

use Phinx\Migration\AbstractMigration;

class CreateTableTimezone extends AbstractMigration
{
    public function change()
    {
        $this->table('timezone')
            ->addColumn('name', 'string')
            ->addColumn('user_id', 'integer')
            ->addColumn('city', 'string')
            ->addColumn('utc_offset', 'integer')
            ->addIndex('user_id')
            ->create();
    }
}
