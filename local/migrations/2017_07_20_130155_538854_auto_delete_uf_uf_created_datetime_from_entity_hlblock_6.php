<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;

class AutoDeleteUfUfCreatedDatetimeFromEntityHlblock620170720130155538854 extends BitrixMigration
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
  'ID' => '16',
  'ENTITY_ID' => 'HLBLOCK_6',
  'FIELD_NAME' => 'UF_CREATED_DATETIME',
  'USER_TYPE_ID' => 'datetime',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'Y',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'DEFAULT_VALUE' => 
    array (
      'TYPE' => 'NOW',
      'VALUE' => '',
    ),
  ),
);
        $id = $this->getUFIdByCode('HLBLOCK_6', 'UF_CREATED_DATETIME');

        $oUserTypeEntity = new CUserTypeEntity();

        $dbResult = $oUserTypeEntity->delete($id);
        if (!$dbResult->result) {
            throw new MigrationException("Не удалось обновить удалить свойство с FIELD_NAME = {$fields['FIELD_NAME']} и ENTITY_ID = {$fields['ENTITY_ID']}");
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
