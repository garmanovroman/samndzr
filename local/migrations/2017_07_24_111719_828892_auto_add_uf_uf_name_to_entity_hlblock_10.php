<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;

class AutoAddUfUfNameToEntityHlblock1020170724111719828892 extends BitrixMigration
{
    /**
     * Run the migration.
     *
     * @return mixed
     * @throws MigrationException
     */
    public function up()
    {
        $fields = array (
  'ENTITY_ID' => 'HLBLOCK_10',
  'FIELD_NAME' => 'UF_NAME',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 'a:6:{s:4:"SIZE";i:20;s:4:"ROWS";i:1;s:6:"REGEXP";s:0:"";s:10:"MIN_LENGTH";i:0;s:10:"MAX_LENGTH";i:0;s:13:"DEFAULT_VALUE";s:0:"";}',
  'EDIT_FORM_LABEL' => 
  array (
    'ru' => 'Название оператора',
    'en' => '',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'ru' => 'Название оператора',
    'en' => '',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'ru' => 'Название оператора',
    'en' => '',
  ),
  'ERROR_MESSAGE' => 
  array (
    'ru' => '',
    'en' => '',
  ),
  'HELP_MESSAGE' => 
  array (
    'ru' => '',
    'en' => '',
  ),
);

        $this->addUF($fields);
    }

    /**
     * Reverse the migration.
     *
     * @return mixed
     * @throws MigrationException
     */
    public function down()
    {
        $id = $this->getUFIdByCode('HLBLOCK_10', 'UF_NAME');
        if (!$id) {
            throw new MigrationException('Не найдено пользовательское свойство для удаления');
        }

        (new CUserTypeEntity())->delete($id);
    }
}
