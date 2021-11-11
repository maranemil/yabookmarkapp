<?php
namespace App\Classes;
use voku\db\exceptions\QueryException;

class Favourites
{

    /**
     * @var int
     */
    private int $iFavouritesId = 0;
    /**
     * @var int
     */
    private int $iBookmarksId = 0;

    /**
     * @return int
     */
    public function getFavouritesId(): int
    {
        return $this->iFavouritesId;
    }

    /**
     * @param $iFavouritesId
     */
    public function setFavouritesId($iFavouritesId)
    {
        $this->iFavouritesId = $iFavouritesId;
    }

    /**
     * @return int
     */
    public function getBookmarksId(): int
    {
        return $this->iBookmarksId;
    }

    /**
     * @param $iBookmarksId
     */
    public function setBookmarksId($iBookmarksId)
    {
        $this->iBookmarksId = $iBookmarksId;
    }

    /**
     * loadFromDB
     *
     * @param int $id
     * @return Favourites
     * @throws QueryException
     */
    public static function loadFromDB(int $id): Favourites
    {
        $db = Database::init();
        $strSQL = "SELECT * FROM favourites WHERE favourites_id=" . $id;
        $result = $db->query($strSQL);
        $arrFetchFavourites = (array)$result->fetchAll();
        $arrFavourites = json_decode(json_encode($arrFetchFavourites), true);
        $arrFavourite = array_shift($arrFavourites);

        // create object
        $oFavourites = new Favourites();
        $oFavourites->setFavouritesId($arrFavourite["favourites_id"]);
        $oFavourites->setBookmarksId($arrFavourite["bookmarks_id"]);

        return $oFavourites;
    }

    /**
     * getInstance
     *
     * @param int|null $id
     * @return Favourites
     * @throws QueryException
     */
    public static function getInstance(?int $id = null): Favourites
    {
        if (is_null($id)) {
            return new Favourites();
        } else {
            return self::loadFromDB($id);
        }
    }

    /**
     * @return Favourites[]
     * @throws QueryException
     */
    public static function getInstances(): array
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM favourites");
        $arrFetchFavourites = (array)$result->fetchAll();
        $arrTmp = json_decode(json_encode($arrFetchFavourites), true);
        $arrInstances = [];
        foreach ($arrTmp as $arrFavourite) {
            $oFavourite = Favourites::getInstance($arrFavourite["favourites_id"]);
            $arrInstances[$oFavourite->getFavouritesId()] = $oFavourite;
        }
        return $arrInstances;
    }

    /**
     * @return array
     * @throws QueryException
     * @noinspection PhpUnused
     */
    public function getFavourites(): array
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM favourites");
        $arrFetchFavourites = (array)$result->fetchAll();
        return json_decode(json_encode($arrFetchFavourites), true);
    }

    /**
     * @return array
     * @throws QueryException
     * @noinspection PhpUnused
     */
    public static function getFavouritesBookmarks(): array
    {
        $aFavourites = self::getInstances();
        $aFavBookmarks = [];
        foreach ($aFavourites as $oFavourite) {
            $aFavBookmarks[$oFavourite->getBookmarksId()] = $oFavourite->getBookmarksId();
        }
        return $aFavBookmarks;
    }

    /**
     * @description - save and update
     * @throws QueryException
     */
    public function save()
    {

        $id = $this->getFavouritesId() ?? 'NULL';
        $db = Database::init();

        $strSQL = "INSERT INTO `favourites`         
                (
                    `favourites_id`,
                    `bookmarks_id`
                )
                VALUES(
                    " . $id . ",
                    " . $this->getBookmarksId() . "
                )
                ON DUPLICATE KEY UPDATE
                    `bookmarks_id` = " . $this->getBookmarksId() . "
                ";
        $db->execSQL($strSQL);
    }

    /**
     * @return void
     * @throws QueryException
     */
    public function delete(): void
    {
        $db = Database::init();
        $strSQL = "DELETE FROM  `favourites` 
            WHERE favourites_id=  " . $this->getFavouritesId();
        $db->execSQL($strSQL);
    }

}
