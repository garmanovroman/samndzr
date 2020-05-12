<?php
namespace App\Admin
{
  use Bitrix\Main\EventManager;
  use CAdminNotify;

  /**
   * Содержит методы для добавления сообщений в админ-панели.
   */
  class NotifyService
  {
    /**
     * Показывает сообщение однократно.
     * @param  string $message Сообщение.
     * @return void
     */
    public static function show($message)
    {
      $id = self::add($message, true);
      self::sessionAdd($id);
    }

    /**
     * Добавляет сообщение в список уведомлений.
     * @param  string  $message Текст сообщения.
     * @param  boolean $isOnce  Показывает, должно ли сообщение быть показано лишь однажды.
     * @return string           ID сообщения.
     */
    public static function add($message, $isOnce = false)
    {
      $tag = self::getTag($isOnce, true);

      return CAdminNotify::Add([
        'MESSAGE' => $message,
        'TAG' => $tag,
        'MODULE_ID' => 'main',
        'ENABLE_CLOSE' => 'Y'
      ]);
    }

    /**
     * Удаляет сообщение по его идентификатору.
     * @param  string $id ID сообщения.
     * @return void
     */
    public static function delete($id)
    {
      CAdminNotify::Delete($id);
    }


    /**
     * Инициалзирует сервис.
     * @return void
     */
    public static function init()
    {
      $events = EventManager::getInstance();
      $events->addEventHandler('main', 'OnPageStart', __CLASS__.'::boot');
    }

    /**
     * Обрабатывает начало работы страницы.
     * @return void
     */
    public static function boot()
    {
      self::sessionInit();
      self::clear();
    }

    /**
     * Получает тег для сообщения.
     * @param  boolean $isOnce   Показывает, является ли сообщение сообщением для однократного показа.
     * @param  boolean $isUnique Показывает, добавлять ли к префиксу уникальное значение.
     * @return string            Тег.
     */
    protected static function getTag($isOnce, $isUnique = false)
    {
      $tag = 'notify-service-';
      
      if ($isOnce) {
        $tag .= 'once-';
      }

      if ($isUnique) {
        $tag = uniqid($tag, true);
      }

      return $tag;
    }

    /**
     * Получает список ID сообщений, показываемых в данный момент и добавленных через
     * API этого класса.
     * @param  boolean  $isOnce Возвращать только сообщения для однократного показа.
     * @return string[]         Массив ID.
     */
    protected static function getList($isOnce = false)
    {
      $mask = self::getTag($isOnce).'%';
      $result = CAdminNotify::GetList(['ID' => 'ASC'], ['TAG' => $mask]);

      while ($item = $result->Fetch()) {
        yield $item['ID'];
      }
    }

    /**
     * Удаляет сообщения, которые должны показываться однократно и уже были показаны.
     * @return void
     */
    protected static function clear()
    {
      $ids = self::getList(true);

      foreach ($ids as $id) {
        $isShow = self::sessionExists($id);

        if ($isShow) {
          self::sessionDelete($id);
          continue;
        }

        self::delete($id);
      }
    }

    /**
     * Инициализирует использование сессии.
     * @return void
     */
    protected static function sessionInit()
    {
      if (isset($_SESSION['notify-service'])) return;

      $_SESSION['notify-service'] = [];
    }

    /**
     * Добавляет ID сообщения в сессию.
     * @param  string $id ID сообщения.
     * @return void
     */
    protected static function sessionAdd($id)
    {
      $_SESSION['notify-service'][$id] = true;
    }

    /**
     * Удаляет ID сообщения из сессии.
     * @param  string $id ID сообщения.
     * @return void
     */
    protected static function sessionDelete($id)
    {
      unset($_SESSION['notify-service'][$id]);
    }

    /**
     * Показывает, существует ли ID в сессии.
     * @param  string  $id ID сообщение.
     * @return boolean     True или false.
     */
    protected static function sessionExists($id)
    {
      return isset($_SESSION['notify-service'][$id]);
    }
  }
}