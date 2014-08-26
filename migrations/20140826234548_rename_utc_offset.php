<?php

use Phinx\Migration\AbstractMigration;

class RenameUtcOffset extends AbstractMigration
{
    public function change()
    {
        $this->table('timezone')
            ->renameColumn('utc_offset', 'utcOffset')
            ->save();
    }
}
