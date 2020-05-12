<?php
namespace App\Model
{
  use App\Rules\Manager as RulesManager;

  /**
   * Модель вопроса.
   */
  class Question extends Base
  {
    /**
     * Поля, включаемые в список сериализации.
     * @var array
     */
    protected $appends = ['GROUP_NAME'];

    /**
     * Строковое представление условий показа вопроса.
     * @var string
     */
    protected $_rulesText = null;

    /**
     * Показывает, было ли изменено условие показа вопроса.
     * @var boolean
     */
    protected $_isRulesTextChanged = false;

    /**
     * Получает имя группы.
     * @return string
     */
    public function getGroupNameAttribute()
    {
      return $this->group['UF_NAME'];
    }

    /**
     * Задает строку с условиями показа вопроса.
     */
    public function setRulesTextAttribute($value)
    {
      if ($this->_rulesText === $value) return;

      $this->_isRulesTextChanged = true;
      $this->_rulesText = $value;
    }

    /**
     * Получает строку с условиями показа вопроса.
     * @return string Строка с условиями показа вопроса.
     */
    public function getRulesTextAttribute()
    {
      if ($this->_rulesText == null) {
        $this->_rulesText = RulesManager::toString($this->rules);
      }

      return $this->_rulesText;
    }

    /**
     * Связанная группа вопроса.
     * @return mixed
     */
    public function group()
    {
      return $this->belongsTo(
        'App\Model\QuestionGroup',
        'UF_QUESTION_GROUP_ID'
      );
    }

    /**
     * Связанные условия показа.
     * @return mixed
     */
    public function rules()
    {
      return $this->hasMany(
        'App\Model\QuestionPropertyValueRule',
        'UF_QUESTION_ID'
      );
    }

    /**
     * Связанный пользователь, который создал вопрос.
     * @return mixed
     */
    public function createdBy()
    {
      return $this->belongsTo(
        'App\Model\User',
        'UF_CREATED_BY'
      );
    }

    /**
     * Связанный пользователь, который изменил вопрос.
     * @return mixed
     */
    public function userChanged()
    {
      return $this->belongsTo(
        'App\Model\User',
        'UF_CHANGED_BY'
      );
    }

    /**
     * Связанные вопросы из тестирования.
     * @return mixed
     */
    public function testingQuestions()
    {
      return $this->hasMany(
        'App\Model\TestingQuestion',
        'UF_QUESTION_ID'
      );
    }

    /**
     * Обрабатывает событие удаление элемента.
     * @param  Question $question Модель вопроса.
     * @return void
     */
    public static function onSaved($question)
    {
      if (!$question->_isRulesTextChanged) return;

      $question->rules()->delete();

      $rules = RulesManager::fromString($question['RULES_TEXT']);
      $question->rules()->saveMany($rules);
    }

    /**
     * Обрабатывает событие удаления вопроса.
     * @param  Question $question Модель вопроса.
     * @return void
     */
    public static function onDeleting($question)
    {
      $isSoft = !$question->testingQuestions->isEmpty();

      if ($isSoft) {
        $question['UF_IS_DELETED'] = true;
        $question->save();
      }

      $question->rules()->delete();

      return !$isSoft;
    }

    /**
     * Прикрепляет обработчики событий.
     * @return void
     */
    protected static function boot()
    {
      parent::boot();
      static::deleting([static::class, 'onDeleting']);
      static::saved([static::class, 'onSaved']);
    }
  }
}
