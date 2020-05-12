<?php
////////////////////////////////////////////////
// Удаляет устаревшие правила показа вопроса. //
////////////////////////////////////////////////

require ($_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__.'/../..')).'/bitrix/modules/main/include/prolog_before.php';
use App\Model\QuestionPropertyValueRule;
use App\Model\Question;

$rules = QuestionPropertyValueRule::get();
$questions = Question::get();
$questions = from($questions)->toDictionary('$v["ID"]');

foreach ($rules as $rule) {
  $id = $rule['UF_QUESTION_ID'];

  $is = isset($questions[$id]);
  if ($is) continue;

  echo $rule['ID'].PHP_EOL;
  $rule->delete();
}

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php';