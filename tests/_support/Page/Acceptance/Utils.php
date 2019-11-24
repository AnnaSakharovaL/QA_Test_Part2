<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace Page\Acceptance;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverExpectedCondition;

class Utils extends \Codeception\Module
{

    private function waitFor(\AcceptanceTester $I, $element)
    {
        $I->waitForElement($element, 30);
    }

    public function buttonClick(\AcceptanceTester $I, $buttonCss)
    {
        $this->waitFor($I, $buttonCss);
        $I->click($buttonCss);
    }

    public function fieldFilling(\AcceptanceTester $I, $fieldCss, $fieldValue)
    {
        $I->waitForElement($fieldCss, 30);
        $I->fillField($fieldCss, $fieldValue);
    }

    public function elementHover(WebDriver $wd, WebDriverElement $element, $elementCss)
    {
        $wd->wait(30)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector($elementCss)));
        $wd->getMouse()->mouseMove($element->getCoordinates());
    }

    public function checkTrailer(\AcceptanceTester $I, WebDriver $wd, WebDriverElement $element, $index, $firstVideoIsBig)
    {
        $firstScreenName = 'screen' . rand(1000000, 9999999) . ".png";
        $secondScreenName = 'screen' . rand(1000000, 9999999) . ".png";
        $x = $element->getLocation()->getX();
        if (($firstVideoIsBig) and ($index > 0)) {
            $y = $element->getLocation()->getY() + ($element->getSize()->getHeight() + $index * 6);
        } else if (($firstVideoIsBig) and ($index == 0)) {
            $y = $element->getLocation()->getY() + ($element->getSize()->getHeight() - 100);
        } else if ((!$firstVideoIsBig) and ($index == 0)) {
            $y = $element->getLocation()->getY() + ($element->getSize()->getHeight() - 50);
        } else {
            $y = $element->getLocation()->getY() + ($element->getSize()->getHeight() - 20 / $index);
        }
        $w = $element->getSize()->getWidth();
        $h = $element->getSize()->getHeight();

        $this->makeElementScreen($firstScreenName, $wd, $x, $y, $w, $h);
        $I->wait(1);
        $this->makeElementScreen($secondScreenName, $wd, $x, $y, $w, $h);
        $this->assertTrue(md5(file_get_contents($firstScreenName)) != md5(file_get_contents($secondScreenName)));

        /**  Альтернативный способ снятия скришота элемента и сравнения различий через утилитку для Codeception - работает немного криво, поэтому проверка может быть неточная */
        //$I->seeVisualChanges('test1', $elementCss);
        //$I->wait(1);
        //$I->seeVisualChanges('test2', $elementCss);
        //$this->assertTrue(file_get_contents('E:\QA_Test_Part2\tests\_data\VisualCeption\VideoTrailerTestCest.videoTrailerTest.test1.png') == file_get_contents('E:\QA_Test_Part2\tests\_data\VisualCeption\VideoTrailerTestCest.videoTrailerTest.test2.png'));
    }

    public function makeElementScreen($fileName, WebDriver $wd, $x, $y, $w, $h)
    {
        $wd->takeScreenshot($fileName);
        $imageFromScreen = imagecreatefrompng($fileName);
        $newImage = imagecreatetruecolor($w, $h);
        imagecopy($newImage, $imageFromScreen, 0, 0, $x, $y, $w, $h);
        imagepng($newImage, $fileName);
        imagedestroy($imageFromScreen);
        imagedestroy($newImage);
    }

    public function getElementFromPage(WebDriver $wd, $elementCss)
    {
        return $wd->findElement(WebDriverBy::cssSelector($elementCss));
    }

    public function getElementsCollectionFromPage(WebDriverElement $rootElement, $searchingElementsCss)
    {
        return $rootElement->findElements(WebDriverBy::cssSelector($searchingElementsCss));
    }

    public function getElementFromOtherElement(WebDriver $wd, WebDriverElement $rootElement, $elementCss)
    {
        $wd->wait(30)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector($elementCss)));
        return $rootElement->findElement(WebDriverBy::cssSelector($elementCss));
    }

    public function getElementsCollectionFromOtherElement(WebDriverElement $rootElement, $searchingElementsCss)
    {
        return $rootElement->findElements(WebDriverBy::cssSelector($searchingElementsCss));
    }

}
