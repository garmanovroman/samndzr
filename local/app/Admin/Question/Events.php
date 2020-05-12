<?php
namespace App\Admin\Question
{
  use Bitrix\Main\EventManager;
  use Bitrix\Main\Entity\EventResult;
  use Bitrix\Main\Entity\EntityError;
  use Bitrix\Main\Application;
  use App\Model\Question;
  use App\Model\Testing;
  use BitrixMonolog\Log;
  use App\Admin\NotifyService;

  /**
   * Содержит методы для обработки событий сохранения
   * и удаления вопроса.
   */
  class Events
  {
    /**
     * Сообщение при мягком удалении вопроса.
     * @var string
     */
    protected static $deleteMessage = 'У вопроса есть зависимые тестирования; вопрос помечен как удаленный.';

    /**
     * Обрабатывает событие сохранения вопроса.
     * @return void
     */
    public static function onSave($e)
    {
      $id = $e->getParameter('id');
      $id = $id['ID'];

      $request = Application::getInstance()->getContext()->getRequest();
      $rules = $request->getPost('RULES');

      $question = $id ? Question::id($id) : Question::orderBy('ID', 'desc')->first();
      $question['RULES_TEXT'] = $rules;
      
      Question::onSaved($question);
    }

    /**
     * Показывает, следует ли откатить удаление вопроса.
     * @var boolean
     */
    protected static $isRollback = false;

    /**
     * Обрабатывает событие удаления вопроса.
     * @return void
     */
    public static function onDelete($e)
    {
      $id = $e->getParameter('id');
      $id = $id['ID'];

      $question = Question::id($id);
      $isDelete = Question::onDeleting($question) !== false;

      if ($isDelete) return;

      $db = Application::getConnection();
      $db->startTransaction();

      self::$isRollback = true;
    }

    /**
     * Обрабатывает событие окончания процесса удаления.
     * @return void
     */
    public static function onDeletePrevent($e)
    {
      if (!self::$isRollback) return;

      $db = Application::getConnection();
      $db->rollbackTransaction();

      NotifyService::show(self::$deleteMessage);
    }

    /**
     * Присваивает обработчики событиям.
     * @return void
     */
    public static function bind()
    {
      $events = EventManager::getInstance();
      $events->addEventHandler('', 'QuestionOnAfterUpdate', __CLASS__.'::onSave');
      $events->addEventHandler('', 'QuestionOnAfterAdd', __CLASS__.'::onSave');
      $events->addEventHandler('', 'QuestionOnBeforeDelete', __CLASS__.'::onDelete');
      $events->addEventHandler('', 'QuestionOnAfterDelete', __CLASS__.'::onDeletePrevent');
    }
  }
}