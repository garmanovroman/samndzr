<?php
namespace App\Model
{
  /**
   * Модель тестирования.
   */
  class Testing extends Base
  {
    /**
     * Связанный объект.
     * @return mixed
     */
    public function object()
    {
      return $this->belongsTo(
        'App\Model\Object',
        'UF_OBJECT_ID'
      );
    }

    /**
     * Связанные вопросы тестирования.
     * @return mixed
     */
    public function questions()
    {
      return $this->hasMany(
        'App\Model\TestingQuestion',
        'UF_TESTING_ID'
      );
    }
  }
}