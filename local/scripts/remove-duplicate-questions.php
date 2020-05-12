<?php
////////////////////////////////////
// Удаляет дублирующиеся вопросы. //
////////////////////////////////////

require ($_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__.'/../..')).'/bitrix/modules/main/include/prolog_before.php';
use App\Model\Question;

function questionText($text) {
  return $text;
}

$questions = Question::get();
$exists = [];

foreach ($questions as $question) {
  $id = $question['ID'];
  $text = questionText($question['UF_TEXT']);

  if (empty($exists[$text])) {
    $exists[$text] = true;
    continue;
  }

  echo $question['UF_TEXT'].PHP_EOL;
  $question->delete();
}

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php';