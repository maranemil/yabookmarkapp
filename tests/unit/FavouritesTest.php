<?php

include_once("src/Classes/Database.php");
include_once("src/Classes/Favourites.php");


class FavouritesTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $instanceId;

    protected function _before()
    {
        // create new Favourite with Bookmark 123
        $oFavourites = new Favourites();
        $oFavourites->setBookmarksId(123);
        $oFavourites->save();
    }

    protected function _after()
    {
        // delete instance
        $oFavourites = Favourites::getInstance($this->instanceId);
        $oFavourites->delete();
    }

    // tests
    public function testCreateAndDestroyEntry()
    {
        #\Codeception\Util\Debug::debug("-- check if fav exists --");
        $db = Database::init();
        $sql = "SELECT * FROM favourites WHERE bookmarks_id=123";
        $result = $db->query($sql);
        $arrFetchFavourites  = (array)$result->fetchAll();
        $arrTmp = json_decode(json_encode($arrFetchFavourites), true);
        $arrSel = array_shift($arrTmp);
        $oFavourites = Favourites::getInstance($arrSel["favourites_id"]);
        $this->instanceId = $arrSel["favourites_id"];        
        $this->assertEquals(123, $oFavourites->getBookmarksId());
        #\Codeception\Util\Debug::debug($this->instanceId);
    }
}