<?php
namespace App\Model
{
  /**
   * Модель объекта тестирования.
   */
  class Object extends Base
  {
    /**
     * Реализует свойство ADDRESS - фактический или юридический адрес объекта.
     * @return string
     */
    public function getAddressAttribute()
    {
      return $this['UF_PHYSICAL_ADDRESS']
        ? $this['UF_PHYSICAL_ADDRESS']
        : $this['UF_JURIDICAL_ADDRESS'];
    }

    /**
     * Реализует свойство NAME - краткое или полное название объекта.
     * @return string Название.
     */
    public function getNameAttribute()
    {
      return $this['UF_SHORT_NAME']
        ? $this['UF_SHORT_NAME']
        : $this['UF_FULL_NAME'];
    }

    /**
     * Связанные значения свойств.
     * @return mixed
     */
    public function propertyValues()
    {
      return $this->belongsToMany(
        'App\Model\PropertyValue',
        'object_property_values',
        'UF_OBJECT_ID',
        'UF_PROPERTY_VALUE_ID'
      );
    }

    /**
     * Связанный пользователь.
     * @return mixed
     */
    public function user()
    {
      return $this->belongsTo(
        'App\Model\User',
        'UF_USER_ID'
      );
    }
  }
}