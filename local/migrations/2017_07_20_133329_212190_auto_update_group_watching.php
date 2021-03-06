<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Highloadblock\HighloadBlockTable;

class AutoUpdateGroupWatching20170720133329212190 extends BitrixMigration
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
  'C_SORT' => '200',
  'NAME' => 'Наблюдение',
  'DESCRIPTION' => 'Пользователи, которые могут смотреть результаты тестирования чужих объектов.',
  'STRING_ID' => 'watching',
  'SECURITY_POLICY' => 'a:0:{}',
  'USER_ID' => 
  array (
  ),
);

        $group->update(6, $fields);

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
