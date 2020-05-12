<?php
namespace App\Admin\Question
{
  use BitrixAdminExtension\Control\Tab as Base;
  use App\Model\Property;
  use App\Model\PropertyValue;
  use App\Model\Operator;
  use App\Model\Question;

  /**
   * Дополнительная вкладка для редактирования свойств вопроса.
   */
  class Tab extends Base
  {
    /**
     * Коллекция свойств для вопроса.
     * @var Iterator<mixed>
     */
    protected $properties;

    /**
     * Текст для автозаполнения.
     * @var string
     */
    protected $autocomplete;

    /**
     * Модель редактируемого вопроса.
     * @var Question
     */
    protected $question;

    /**
     * Создает экземпляр класса.
     */
    public function __construct()
    {
      $text = 'Условия показа';
      $title = 'Настройка условий показа вопроса';
      $template = __DIR__.'/TabTemplate.php';

      parent::__construct($text, $title, $template);
    }

    /**
     * Инициализирует вкладку.
     * @return void
     */
    public function initialize()
    {
      parent::initialize();

      $this->addCss('local/app/Admin/Question/Assets/Vendor/Autocomplete/css/jquery.tagit.css');
      $this->addCss('local/app/Admin/Question/Assets/Vendor/Autocomplete/css/tagit.ui-zendesk.css');
      $this->addCss('local/app/Admin/Question/Assets/style.css');

      $this->addJs('local/app/Admin/Question/Assets/Vendor/jquery.min.js');
      $this->addJs('local/app/Admin/Question/Assets/Vendor/jquery-ui/jquery-ui.min.js');
      $this->addJs('local/app/Admin/Question/Assets/Vendor/Autocomplete/js/tag-it.min.js');
      $this->addJs('local/app/Admin/Question/Assets/script.js');

      $id = $_REQUEST['ID'];

      if ($id) {
        $this->question = Question::id($id);
      }

      $this->properties = Property::with('values')->get();
      $this->operators = Operator::get();
      
      $this->autocomplete = ['(', ')'];
      
      foreach ($this->operators as $opertator) {
        $this->autocomplete[] = $opertator['UF_NAME'];
      }

      foreach ($this->properties as $property) {
        foreach ($property->values as $value) {
          $this->autocomplete[] = $value['UF_VALUE'];
        }
      }

      $this->autocomplete = json_encode($this->autocomplete);
    }
  }
}