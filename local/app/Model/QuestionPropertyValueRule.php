<?php
namespace App\Model
{
  /**
   * Модель вопроса части условия показа вопроса.
   */
  class QuestionPropertyValueRule extends Base
  {
    /**
     * Получает название оператора.
     * @return string Название оператора.
     */
    public function getOperatorTextAttribute()
    {
      $operator = $this->operator;
      return $operator ? $operator['UF_NAME'] : null;
    }

    /**
     * Получает название значения свойства.
     * @return string Значение свойства.
     */
    public function getPropertyValueTextAttribute()
    {
      $value = $this->propertyValue;
      return $value ? $value['UF_VALUE'] : null;
    }

    /**
     * Показывает, является ли элемент оператором.
     * @return boolean True или false.
     */
    public function getIsOperatorAttribute()
    {
      return !$this['UF_PROPERTY_VALUE_ID'];
    }

    /**
     * Показывает, является ли элемент значением свойства.
     * @return boolean True или false.
     */
    public function getIsValueAttribute()
    {
      return !$this['UF_OPERATOR_ID'];
    }

    /**
     * Связанный вопрос.
     * @return mixed
     */
    public function question()
    {
      return $this->belongsTo(
        'App\Model\Question',
        'UF_QUESTION_ID'
      );
    }

    /**
     * Связанный оператор.
     * @return mixed
     */
    public function operator()
    {
      return $this->belongsTo(
        'App\Model\Operator',
        'UF_OPERATOR_ID'
      );
    }

    /**
     * Связанное значение свойства.
     * @return mixed
     */
    public function propertyValue()
    {
      return $this->belongsTo(
        'App\Model\PropertyValue',
        'UF_PROPERTY_VALUE_ID'
      );
    }
  }
}
