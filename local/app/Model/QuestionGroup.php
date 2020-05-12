<?php
namespace App\Model
{
  /**
   * Модель группы вопросов.
   */
  class QuestionGroup extends Base
  {
    /**
     * Связанные вопросы.
     * @return mixed
     */
    public function questions()
    {
      return $this->hasMany(
        'App\Model\Question',
        'UF_QUESTION_GROUP_ID'
      );
    }
  }
}