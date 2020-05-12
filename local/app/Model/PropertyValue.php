<?php
namespace App\Model
{
  /**
   * Модель значения свойства.
   */
  class PropertyValue extends Base
  {
    /**
     * Связанное свойство.
     * @return Property
     */
    public function property()
    {
      return $this->belongsTo(
        'App\Model\Property',
        'UF_PROPERTY_ID'
      );
    }
  }
}