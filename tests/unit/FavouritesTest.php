<?php /** @noinspection SqlDialectInspection */
/** @noinspection PhpUnused */

include_once("src/Classes/Database.php");
include_once("src/Classes/Favourites.php");


class FavouritesTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /**
     * @var int $instanceId
     */
    private int $instanceId;

    /**
     * @return void
     */
    protected function _before(): void
    {
        // create new Favourite with Bookmark 123
        $oFavourites = new Favourites();
        $oFavourites->setBookmarksId(123);
        $oFavourites->save();
    }

    /**
     * @return void
     */
    protected function _after(): void
    {
        // delete instance
        $oFavourites = Favourites::getInstance($this->instanceId);
        $oFavourites->delete();
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function testCreateAndDestroyEntry(): void
    {
        #\Codeception\Util\Debug::debug("-- check if fav exists --");
        $db = Database::init();
        $sql = "SELECT * FROM favourites WHERE bookmarks_id=123";
        $result = $db->query($sql);
        $arrFetchFavourites = (array)$result->fetchAll();
        $arrTmp = json_decode(json_encode($arrFetchFavourites, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
        $arrSel = array_shift($arrTmp);
        $oFavourites = Favourites::getInstance($arrSel["favourites_id"]);
        $this->instanceId = $arrSel["favourites_id"];
        $this->assertEquals(123, $oFavourites->getBookmarksId());
        #\Codeception\Util\Debug::debug($this->instanceId);
    }
}