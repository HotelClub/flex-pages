<?php

ini_set('display_errors', 'On');

/**
 *
 * @package    index.php
 * @author     Rakesh Shrestha
 * @since      17/7/15 4:13 PM
 * @version    1.0
 */
session_start();
class flexPage
{
    const DEFAULT_LOCALE = 'en_AU';

    protected $locale;
    protected $groupName;
    protected $templateName;
    protected $templateHtml;
    protected $contentHtml;


    public function __construct(){
        $this->parseUriPath();
        $this->setTemplateHtml();
        $this->setContentHtml();
    }

    public function build() {

        $pageHtml = str_replace("##HTML##", $this->getContentHtml(), $this->getTemplateHtml());
//        echo '<!DOCTYPE html><head><meta charset="UTF-8" /></head><body>' . PHP_EOL . PHP_EOL;
        echo $pageHtml;
//        echo PHP_EOL .PHP_EOL . '</body></html>';
    }

    /**
     * @return mixed
     */
    public function getTemplateHtml()
    {
        if(null === $this->templateHtml) $this->setTemplateHtml();
        return $this->templateHtml;
    }

    /**
     * @return $this
     */
    public function setTemplateHtml()
    {
        if(null !== $this->getTemplateName() && null !== $this->getGroupName()) {

            $templateFilePath   = __DIR__ . '/templates/' . $this->getGroupName() . '/' . $this->getTemplateName(
                ) . '.xml';
            $templateHtml       = file_exists($templateFilePath) ? file_get_contents($templateFilePath) : '';
            $this->templateHtml = $templateHtml;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentHtml()
    {
        if(null === $this->contentHtml) $this->setContentHtml();
        return $this->contentHtml;
    }

    /**
     * @return $this
     */
    public function setContentHtml()
    {
        if(null !== $this->getTemplateName() && null !== $this->getGroupName()) {
            //$filePath   = __DIR__ . '/pages/' . $this->getGroupName() . '/' . $this->getTemplateName() . '/' . $this->getTemplateName(). '_' . $this->getLocale()  . '.html';
			$filePath   = __DIR__ . '/pages/' . $this->getGroupName() . '/' . $this->getTemplateName() . '/' . $this->getTemplateName(). '.html';
	        $contentHtml = file_exists($filePath) ? file_get_contents($filePath) : '';

			/*code to fetch json locale file and replace with place holders*/
			$placeholderPath = __DIR__ . '/data/'.$this->getTemplateName().'.json';
			$reusableTextPath = __DIR__ . '/data/data-reusable.json';
			$menuTextPath = __DIR__ . '/data/menu-text.json';
			
			$placeholderContents = file_get_contents($placeholderPath);
			$reusableContents = file_get_contents($reusableTextPath);
			$menuTextContents = file_get_contents($menuTextPath);
			
			$placeholderContentsA = json_decode($placeholderContents,true);
			$reusableContentsA =  json_decode($reusableContents,true);
			$menuTextContentsA =  json_decode($menuTextContents,true);
			
			$addedResuableArrays = [];
			$allTextArray = [];
			
			foreach($placeholderContentsA as $locale => $data){
				$addedResuableArrays[$locale] = array_merge($data, $reusableContentsA[$locale]);
			}
			
			foreach($addedResuableArrays as $locale=> $data){
				$allTextArray[$locale] = array_merge($data, $menuTextContentsA[$locale]);
			}

			/* echo '<pre>*';
			print_r($allTextArray);
			echo '</pre>';
			exit; */
			
			$getLocalVal = strtolower($this->getLocale());
			$contentHtml = str_replace("/mktg/","/".$getLocalVal."/mktg/",$contentHtml);
			$contentHtml = str_replace("##locale##",$this->getCamelCaseLocale($getLocalVal),$contentHtml);
			foreach($allTextArray[$getLocalVal] as $key=>$val){
				
				$contentHtml = str_replace("[".$key."]",$val,$contentHtml);
			}
            $this->contentHtml = $contentHtml;
        }
        return $this;
    }


    protected function parseUriPath()
    {
        $path      = !empty($_REQUEST['path']) ? $_REQUEST['path'] : '/';
        $pathItems = explode('/', $path);
        if (!empty($pathItems[0])) {
            preg_match_all("/[a-z]{2}_[a-zA-Z]{2}/", $pathItems[0], $match);
            if (!empty($match[0][0])) {
                $this->locale = $match[0][0];
            } else {
                $this->groupName = $pathItems[0];
            }
        }

        if (!empty($pathItems[1])) {
            if(null === $this->getGroupName()){
                $this->groupName = $pathItems[1];
            } else {
                $this->templateName = $pathItems[1];
            }

        }
        if (!empty($pathItems[2])) {
            if(null === $this->getTemplateName()){
                $this->templateName = $pathItems[2];
            }
        }
        $this->locale = $this->getLocale();

        return $this;

    }

    /**
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param mixed $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }


    /**
     * @return mixed
     */
    public function getLocale()
    {
        if(null === $this->locale) $this->parseLocale();
        return $this->locale;
    }

    protected function  parseLocale(){
        $localeInSession = !empty($_SESSION['locale']) ? $_SESSION['locale'] : null;
        $localeInRequest = !empty($_REQUEST['locale']) ? $_REQUEST['locale'] : null;
        $locale = null === $localeInRequest ? $localeInSession : $localeInRequest;
        $locale = null === $locale ? self::DEFAULT_LOCALE : $locale;

        $this->locale = $locale;
        $_SESSION['locale'] = $locale;
        return $this;

    }

    public function setLocale($locale)
    {
    $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @param mixed $templateName
     */
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }

    public function getCamelCaseLocale($locale){
        $localePart = explode("_", $locale);
        if(!empty($localePart) && count($localePart) ==2) {
            $localePart[1] = strtoupper($localePart[1]);
            return implode("_", $localePart);
        } else {
            return $locale;
        }

    }


}

$flexpage = new flexPage();
$flexpage->build();
