<?
  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

  use Bitrix\Main\Page\Asset;

  global $APPLICATION;
  global $USER;

  $assets = Asset::getInstance();

  $page = $APPLICATION->GetCurPage();
  $page_is_404 = defined('ERROR_404') && ERROR_404 == 'Y';
  $page_is_main = $page === '/';

  $site = CSite::GetById(SITE_ID)->GetNext();
  $site_name = $site['NAME'];
  $site_is_admin = $USER->IsAdmin();

  $assets->addCss(SITE_TEMPLATE_PATH.'/style.css');
  $assets->addJs(SITE_TEMPLATE_PATH.'/script.js');

  CJSCore::Init();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  <title><?= $APPLICATION->ShowTitle(); ?></title>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <?
    $APPLICATION->ShowMeta("description", false, false);
    $APPLICATION->ShowMeta("keywords", false, false);
    $APPLICATION->ShowMeta("robots", false, false);

    $APPLICATION->ShowCSS(true, false);

    if ($site_is_admin) {
      $APPLICATION->ShowHeadStrings();
      $APPLICATION->ShowHeadScripts();
    }
  ?>
</head>
<body>
  <? if ($site_is_admin) : ?>
    <div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
  <? endif; ?>
  <h1><?= $APPLICATION->ShowTitle(); ?></h1>