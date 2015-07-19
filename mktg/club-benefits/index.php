<?php
session_start();

$_SESSION['locale'] = !empty($_SESSION['locale']) ? $_SESSION['locale'] : 'en_AU';
//override
if(!empty($_REQUEST['locale'])) $_SESSION['locale']= $_REQUEST['locale'];

$locale = $_SESSION['locale'];
$fileName = basename(__DIR__) . '_' . $locale .'.html';
if(file_exists($fileName)) include_once($fileName);