<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Highloadblock\HighloadBlockTable;

class AutoUpdateGroupTesting20170720133509234460 extends BitrixMigration
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
  'NAME' => 'Прохождение тестов',
  'DESCRIPTION' => 'Пользователь, который может добавлять свои объекты и проходить тестирование.',
  'STRING_ID' => 'testing',
  'SECURITY_POLICY' => 'a:0:{}',
  'USER_ID' => 
  array (
  ),
);

        $group->update(5, $fields);

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
