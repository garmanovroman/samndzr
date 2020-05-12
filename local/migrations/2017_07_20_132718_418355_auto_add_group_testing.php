<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Highloadblock\HighloadBlockTable;

class AutoAddGroupTesting20170720132718418355 extends BitrixMigration
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
  'C_SORT' => '100',
  'NAME' => 'Тестирование',
  'DESCRIPTION' => 'Пользователь, который может добавлять свои объекты и проходить тестирование.',
  'STRING_ID' => 'testing',
  'SECURITY_POLICY' => 'a:0:{}',
  'USER_ID' => 
  array (
  ),
);

        $id = $group->add($fields);

        if ($group->LAST_ERROR) {
            throw new MigrationException('Ошибка при добавлении группы '.$group->LAST_ERROR);
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
