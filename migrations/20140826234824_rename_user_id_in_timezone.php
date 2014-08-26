<?php

use Phinx\Migration\AbstractMigration;

class RenameUserIdInTimezone extends AbstractMigration
{
    public function change()
    {
        $this->table('timezone')
            ->renameColumn('user_id', 'userId')
            ->save();
    }
}
