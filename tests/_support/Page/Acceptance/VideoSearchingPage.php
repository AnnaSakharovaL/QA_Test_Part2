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
    public static $videoCss = 'div.serp-item__preview.serp-item__preview_rounded';
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
        $videosList = $this->getElementsCollectionFromPage($searchingResult, self::$videoCss);
        $videoNumber = 1;
        $video = $videosList[$videoNumber];
        $firstVideoIsBig = false;

        /** у Яндекса разное поведение при выполнении поиска видео - иногда первое видео увеличено, иногда - нет, отсюда разное определение механизма обрезки, это условие для определения, увеличено ли первое видео*/
        if ($videosList[0]->getSize()->getWidth() > 184) {
            $firstVideoIsBig = true;
        }
        $this->elementHover($this->wd, $video, self::$videoCss);

        /** Проверка на случай, если наводим на элемент, выходящий за нижний край экрана (например на 10-е видео), чтобы обновить данные о списке видео и для того, чтобы селениум смог посчитать позицию. Здесь есть небольшая неточность, на разных размерах экрана позиции передаваемых для проверки элементов могут отличаться. Приведение к универсальности в процессе проработки */
        if (($videoNumber > 4) and ($firstVideoIsBig)) {
            $videosList = $this->getElementsCollectionFromPage($searchingResult, self::$videoCss);
            $this->checkTrailer($this->I, $this->wd, $videosList[3], $videoNumber, $firstVideoIsBig);
        } else if (($videoNumber > 4) and (!$firstVideoIsBig)) {
            $videosList = $this->getElementsCollectionFromPage($searchingResult, self::$videoCss);
            $this->checkTrailer($this->I, $this->wd, $videosList[5], $videoNumber, $firstVideoIsBig);
        } else {
            $this->checkTrailer($this->I, $this->wd, $video, $videoNumber, $firstVideoIsBig);
        }
    }

}
