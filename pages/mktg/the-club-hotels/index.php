<?php
/**
 *
 * @package    index.php
 * @author     Rakesh Shrestha
 * @since      17/7/15 4:13 PM
 * @version    1.0
 */
session_start();

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