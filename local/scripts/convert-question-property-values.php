<?php
/////////////////////////////////////////////////////////////////////////////
// Переносит значения QuestionPropertyValues в QuestionPropertyValueRules. //
/////////////////////////////////////////////////////////////////////////////

require ($_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__.'/../..')).'/bitrix/modules/main/include/prolog_before.php';
use App\Model\PropertyValue;
use App\Model\Question;
use App\Model\QuestionPropertyValueRule;
use Illuminate\Database\Capsule\Manager as Capsule;

$pivot = Capsule::table('question_property_values')->get();
$questionIds = [];
$valueIds = [];

foreach ($pivot as $item) {
  $valueIds[] = $item->UF_PROPERTY_VALUE_ID;
  $questionIds[] = $item->UF_QUESTION_ID;
}

$questionIds = array_values(array_unique($questionIds));
$valueIds = array_values(array_unique($valueIds));

$questions = Question::id($questionIds);
$values = PropertyValue::id($valueIds);

$questions = from($questions)->toDictionary('$v["ID"]');
$values = from($values)->toDictionary('$v["ID"]');

$rules = [];

foreach ($pivot as $item) {
  $value = $values[$item->UF_PROPERTY_VALUE_ID];

  $key = $item->UF_QUESTION_ID;

  if (!isset($rules[$key])) {
    $rules[$key] = [];
  }

  $rules[$key][] = $value;
}

foreach ($rules as $key => $list) {
  $text = from($list)->select('$v["UF_VALUE"]')->toArray();
  $text = implode(';ИЛИ;', $text);

  $question = $questions[$key];
  if (empty($question)) continue;

  $question['UF_TEXT'] = preg_replace('/^_*(.*)/', '$1', $question['UF_TEXT']);
  $question['RULES_TEXT'] = $text;
  $question->save();

  echo $question['ID'].' -> '.$text.PHP_EOL;
}

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php';