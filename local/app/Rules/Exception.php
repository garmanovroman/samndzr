<?php
namespace App\Rules
{
  use Exception as Base;

  /**
   * Ошибка во время разбора условий показа вопросов.
   */
  class Exception extends Base
  {
    /**
     * Номер неверной лексемы.
     * @var integer
     */
    protected $index;

    /**
     * Создает экземпляр класса.
     * @param integer  $index   Позиция неверной лексемы.
     * @param string   $message Сообщение об ошибке.
     * @param integer  $code    Код ошибки.
     */
    public function __construct($index, $message = '')
    {
      parent::__construct($message);
      $this->index = $index;
    }

    /**
     * Получает номер неверной лексемы.
     * @return integer
     */
    public function getIndex()
    {
      return $this->index;
    }
  }
}