<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Highloadblock\HighloadBlockTable;

class AutoUpdateGroupConsulting20170720133525365088 extends BitrixMigration
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
  'C_SORT' => '300',
  'NAME' => 'Консультация',
  'DESCRIPTION' => 'Пользователи, отвечающие на вопросы гостей портала.',
  'STRING_ID' => 'consulting',
  'SECURITY_POLICY' => 'a:0:{}',
  'USER_ID' => 
  array (
  ),
);

        $group->update(7, $fields);

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
