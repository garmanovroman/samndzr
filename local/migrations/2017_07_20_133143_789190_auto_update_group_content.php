<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Highloadblock\HighloadBlockTable;

class AutoUpdateGroupContent20170720133143789190 extends BitrixMigration
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
        $fields = array (
  'ACTIVE' => 'Y',
  'C_SORT' => '400',
  'NAME' => 'Наполнение',
  'DESCRIPTION' => 'Пользователи, отвечающие за контент портала.',
  'STRING_ID' => 'content',
  'SECURITY_POLICY' => 'a:0:{}',
  'USER_ID' => 
  array (
  ),
);

        $group->update(8, $fields);

        if ($group->LAST_ERROR) {
            throw new MigrationException('Ошибка при обновлении группы '.$group->LAST_ERROR);
        }
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
