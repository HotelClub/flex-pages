<?php
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
            $filePath   = __DIR__ . '/pages/' . $this->getGroupName() . '/' . $this->getTemplateName() . '/' . $this->getTemplateName(). '_' . $this->getLocale()  . '.html';
	        $contentHtml = file_exists($filePath) ? file_get_contents($filePath) : '';

			/*code to fetch json locale file and replace with place holders*/
			$placeholderPath = __DIR__ . '/data/'.$this->getTemplateName().'.json';
			$placeholderContents = json_decode(file_get_contents($placeholderPath));
			$getLocalVal = $this->getLocale();
			foreach($placeholderContents->$getLocalVal as $key=>$val){
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




}

$flexpage = new flexPage();
$flexpage->build();
