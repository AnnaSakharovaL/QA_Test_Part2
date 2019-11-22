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

    public function checkElementIsVisible(WebDriver $wd, WebDriverElement $element, $elementCss)
    {
        $wd->wait(30)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector($elementCss)));
        $this->assertTrue($element->isEnabled());
    }

    public function getElementFromPage(WebDriver $wd, $elementCss)
    {
        return $wd->findElement(WebDriverBy::cssSelector($elementCss));
    }

    public function getElementsCollectionFromPage(WebDriver $wd, $searchingElementsCss)
    {
        return $wd->findElements(WebDriverBy::cssSelector($searchingElementsCss));
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
