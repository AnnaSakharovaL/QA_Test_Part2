<?php

use Page\Acceptance\VideoSearchingPage;

class VideoTrailerTestCest
{

    public function _before(\AcceptanceTester $I)
    {
    }

    // tests
    public function videoTrailerTest(\AcceptanceTester $I)
    {
        $I->wantTo('Find video and check the trailer');
        $U = new VideoSearchingPage($I);
        $U->goToVideoSearchingPage();
        $U->waitForSearchingField();
        $U->searchVideo('ураган');
        $U->waitForVideosList();
        $U->checkVideoTrailer();
    }
}
