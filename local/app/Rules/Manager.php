<?php
namespace App\Rules
{
  use App\Model\Operator;
  use App\Model\PropertyValue;
  use App\Model\QuestionPropertyValueRule;

  /**
   * Содержит методы, связанные с операциями над условиями показа.
   */
  class Manager
  {
    /**
     * Получает перечисление необработанных лексем для записи выражения в обратной польской нотации.
     * @param  string                    $string Исходная строка.
     * @return Iterator<string|Operator>         Перечисление имен свойств и моделей операторов в
     *                                           обратной польской нотации.
     */
    protected static function fromStringTokens($string)
    {
      if (empty($string)) return;

      $input = explode(';', $string);
      $stack = [];

      $operators = Operator::get();
      $operators = from($operators)->toDictionary('$v["UF_NAME"]');

      $index = -1;

      foreach ($input as $item) {
        $isOpertator = isset($operators[$item]);
        $isBracketOpen = $item === '(';
        $isBracketClose = $item === ')';
        $isBracket = $isBracketOpen || $isBracketClose;
        $isValue = !$isOpertator && !$isBracket;

        $index += 1;

        if ($isValue) {
          yield $item;
          continue;
        }

        if ($isBracketOpen) {
          $stack[] = $item;
          continue;
        }

        if ($isBracketClose) {
          $isFind = false;

          while (count($stack) > 0) {
            $peek = array_pop($stack);

            if ($peek === '(') {
              $isFind = true;
              break;
            }

            yield $peek;
          }

          if ($isFind) continue;

          throw new Exception($index);
        }

        $operator = $operators[$item];
        $priority = $operator['UF_PRIORITY'];

        $count = count($stack);

        while (true) {
          if ($count === 0) break;

          $peek = $stack[$count - 1];

          $isBreak = $priority > $peek['UF_PRIORITY'];
          if ($isBreak) break;

          yield array_pop($stack);
          $count -= 1;
        }

        $stack[] = $operator;
      }

      while (count($stack)) {
        yield array_pop($stack);
      }
    }

    /**
     * Преобразует строковое представление условий показа вопроса в массив правил.
     * @param  string                                    $string Строковое представление
     *                                                           условий показа.
     * @return array<App\Mode\QuestionPropertyValueRule>         Массив правил.
     */
    public static function fromString($string)
    {
      $iterator = self::fromStringTokens($string);
      $values = [];
      $tokens = [];

      foreach ($iterator as $token) {
        $tokens[] = $token;
        if (!is_string($token)) continue;

        $values[] = $token;
      }

      if (empty($tokens)) return;

      $values = PropertyValue::whereIn('UF_VALUE', $values)->get();
      $values = from($values)->toDictionary('$v["UF_VALUE"]');

      foreach ($tokens as $token) {
        $rule = new QuestionPropertyValueRule();

        if (!is_string($token)) {
          $rule['UF_OPERATOR_ID'] = $token['ID'];
          yield $rule;
          continue;
        }

        $value = $values[$token];
        $rule['UF_PROPERTY_VALUE_ID'] = $value['ID'];
        yield $rule;
      }
    }

    /**
     * Получает текст фрейма стека при преобразовании в инфиксную нотацию, если нужно,
     * обрамляя его в скобки.
     * @param  array   &$stack   Стек записей.
     * @param  integer $priority Приоритет читаемой операции.
     * @return string            Текст фрейма стека.
     */
    protected static function toStringPop(&$stack, $priority)
    {
      $frame = array_pop($stack);

      $priorityFrame = $frame[1];
      $text = $frame[0];

      $isBrackets = $priorityFrame < $priority;

      if ($isBrackets) {
        $text = '(;'.$text.';)';
      }

      return $text;
    }

    /**
     * Получает строковое представление списка правил показа вопроса.
     * @param  Iterator<QuestionPropertyValueRule> $rules Перечисление правил показа вопроса.
     * @return string                                     Строковое представление.
     */
    public static function toString($rules)
    {
      if (empty($rules)) return '';
      
      $stack = [];

      foreach ($rules as $rule) {

        if ($rule->isValue) {
          $stack[] = [$rule['PROPERTY_VALUE_TEXT'], PHP_INT_MAX];
          continue;
        }

        $operator = $rule->operator;
        $isBinary = $operator['UF_IS_BINARY'];
        $priority = $operator['UF_PRIORITY'];

        $text = self::toStringPop($stack, $priority);
        $text = $operator['UF_NAME'].';'.$text;

        if ($isBinary) {
          $left = self::toStringPop($stack, $priority);
          $text = $left.';'.$text;
        }

        $stack[] = [$text, $priority];
      }

      $frame = array_pop($stack);
      return $frame[0];
    }
  }
}