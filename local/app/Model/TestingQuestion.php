<?php
namespace App\Model
{
  /**
   * Модель вопроса тестирования.
   */
  class TestingQuestion extends Base
  {
    /**
     * Связанное тестирование.
     * @return mixed
     */
    public function testing()
    {
      return $this->belongsTo(
        'App\Model\Testing',
        'UF_TESTING_ID'
      );
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
  }
}