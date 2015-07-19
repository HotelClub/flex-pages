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
if(file_exists($fileName)) include_once($fileName);