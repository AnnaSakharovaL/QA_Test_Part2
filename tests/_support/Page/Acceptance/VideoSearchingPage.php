<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace Page\Acceptance;

use \Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;

class VideoSearchingPage extends Utils
{
    public static $url = 'https://yandex.ru/video/';
    public static $searchFieldCss = 'input';
    public static $searchStartButtonCss = 'button.websearch-button';
    public static $foundVideosListCss = 'div.serp-controller__content';
    public static $videoCss = 'div.thumb-image__preview.thumb-preview__target';
    public static $trailerCss = 'video.thumb-preview__video';

    /**
     * @var \AcceptanceTester;
     */
    protected $I;
    protected $wd;

    public function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
        $this->wd = $I->executeInSelenium(function (WebDriver $webDriver) {
            return $webDriver;
        });
    }

    private function wait($element)
    {
        $this->I->waitForElement($element, 30);
    }

    public function goToVideoSearchingPage()
    {
        $this->I->amOnPage('/video');
    }

    public function waitForSearchingField()
    {
        $this->wait(self::$searchFieldCss);
        $this->I->seeElement(self::$searchFieldCss);
    }

    public function searchVideo($videoName)
    {
        $this->fieldFilling($this->I, self::$searchFieldCss, $videoName);
        $this->buttonClick($this->I, self::$searchStartButtonCss);
    }

    public function waitForVideosList()
    {
        $this->wait(self::$foundVideosListCss);
    }

    public function checkVideoTrailer()
    {
        $searchingResult = $this->getElementFromPage($this->wd, self::$foundVideosListCss);
        $videosList = $this->getElementsCollectionFromOtherElement($searchingResult, self::$videoCss);
        $video = $videosList[0];
        $this->elementHover($this->wd, $video, self::$videoCss);
        $trailer = $video->findElement(WebDriverBy::cssSelector(self::$trailerCss));
        $this->checkElementIsVisible($this->wd, $trailer, self::$trailerCss);
    }

}
