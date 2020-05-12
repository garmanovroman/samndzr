<?php
namespace App\Admin\Question
{
  use BitrixAdminExtension\Page\Highload\Edit as HighloadEditPage;

  /**
   * Расширяет функционал админки для highload-блока Question.
   */
  class Service
  {
    /**
     * Добавляет новую вкладку на страницу редактирования.
     */
    protected static function addTab()
    {
      $page = new HighloadEditPage('Question');
      $tab = new Tab();
      $page->addTab($tab);
    }

    /**
     * Инициализирует класс.
     * @return void
     */
    public static function init()
    {
      Events::bind();
      self::addTab();
    }
  }
}