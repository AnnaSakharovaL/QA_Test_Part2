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

    public function checkElementIsVisible(\AcceptanceTester $I, WebDriver $wd, WebDriverElement $element, $elementCss)
    {
        //$wd->wait(30)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector($elementCss)));
        //$this->assertTrue($element->isEnabled());
        $screen = $wd->takeScreenshot('screen2.png');
        $x = $element->getLocation()->getX();
        $y = $element->getLocation()->getY();
        $r = $element->getSize()->getWidth();
        $d = $element->getSize()->getHeight();

        //$left = $element->getLocation()->getX();
        //$top = $element->getLocation()->getY();
        //$right = $element->getSize()->getWidth();
        //$bottom = $element->getSize()->getHeight();

        print $element->getLocation()->getX() . "\n";
        print $element->getLocation()->getY() . "\n";
        print $element->getSize()->getWidth(). "\n";
        print $element->getSize()->getHeight() . "\n";
        print ("---------------------------");


        //print $left . "\n";
        //print $top . "\n";
        //print $right . "\n";
        //print $bottom . "\n";

        $imageFromScreen = imagecreatefrompng('screen2.png');

        $newImage = imagecreatetruecolor($element->getSize()->getWidth(), $element->getSize()->getHeight());
        imagecopy($newImage, $imageFromScreen, 0, 0, $x, $y, $r, -$d);
        imagepng($newImage, 'screen3.png');
        imagedestroy($imageFromScreen);
        imagedestroy($newImage);



        //$I->seeVisualChanges('test1', $elementCss);
        //$I->seeVisualChanges('test2', $elementCss);
        //$this->assertTrue(file_get_contents('E:\QA_Test_Part2\tests\_data\VisualCeption\VideoTrailerTestCest.videoTrailerTest.test1.png') == file_get_contents('E:\QA_Test_Part2\tests\_data\VisualCeption\VideoTrailerTestCest.videoTrailerTest.test2.png'));

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
