<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Highloadblock\HighloadBlockTable;

class AutoDeleteGroupContent20170720140228741329 extends BitrixMigration
{
    /**
     * Run the migration.
     *
     * @return mixed
     * @throws MigrationException
     */
    public function up()
    {
        $group = new CGroup;

        $this->db->startTransaction();
        if (!$group->delete(8)) {
            $this->db->rollbackTransaction();
            throw new MigrationException('Ошибка при удалении группы '.$group->LAST_ERROR);
        }
        $this->db->commitTransaction();
    }

    /**
     * Reverse the migration.
     *
     * @return mixed
     * @throws MigrationException
     */
    public function down()
    {
        return false;
    }
}
