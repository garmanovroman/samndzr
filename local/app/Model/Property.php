<?php
namespace App\Model
{
  /**
   * Модель свойства.
   */
  class Property extends Base
  {
    /**
     * Имя таблицы в БД.
     * @var string
     */
    protected $table = 'properties';

    /**
     * Связанные значения свойства.
     * @return mixed
     */
    public function values()
    {
      return $this->hasMany(
        'App\Model\PropertyValue',
        'UF_PROPERTY_ID'
      );
    }
  }
}