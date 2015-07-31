<?php
/**
 *
 * @package    index.php
 * @author     Rakesh Shrestha
 * @since      17/7/15 4:13 PM
 * @version    1.0
 */
session_start();
$locales = [
    'de_DE' => 'Deutsch',
    'en_AU' => 'English',
    'es_ES' => 'Español',
    'fr_FR' => 'Français',
    'id_ID' => 'Bahasa Indonesia',
    'it_IT' => 'Italiano',
    'ja_JP' => '日本語',
    'ko_KR' => '한국어',
    'ms_MY' => 'Bahasa Malaysia',
    'nl_NL' => 'Nederlands',
    'pl_PL' => 'Polski',
    'pt_PT' => 'Português',
    'ru_RU' => 'Русский',
    'sv_SE' => 'Svenska',
    'th_TH' => 'ไทย',
    'zh_CN' => '简体中文',
    'zh_HK' => '繁體中文 (香港)',
    'zh_TW' => '繁體中文 (台灣)'
];

$_SESSION['locale'] = !empty($_SESSION['locale']) ? $_SESSION['locale'] : 'en_AU';
//override
if(!empty($_REQUEST['locale'])) $_SESSION['locale']= $_REQUEST['locale'];

$locale = $_SESSION['locale'];
$fileName = basename(__DIR__) . '_' . $locale .'.html';
$templateName = __DIR__ .'/../../flex-templates/Marketing/'. basename(__DIR__) . '.xml';
if(file_exists($fileName)) $html = file_get_contents($fileName);
$template = file_get_contents($templateName);
$html = str_replace("##HTML##", $html, $template);



echo $html;


