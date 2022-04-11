<?php

/** @noinspection SqlDialectInspection */
/** @noinspection AmbiguousMethodsCallsInArrayMappingInspection */
/** @noinspection StaticInvocationViaThisInspection */

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Classes;

use JsonException;
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
    public function setFavouritesId($iFavouritesId): void
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
    public function setBookmarksId($iBookmarksId): void
    {
        $this->iBookmarksId = $iBookmarksId;
    }

    /**
     * loadFromDB
     *
     * @param int $id
     * @return Favourites
     * @throws QueryException
     * @throws JsonException
     */
    public static function loadFromDB(int $id): Favourites
    {
        $db = Database::init();
        $strSQL = "SELECT * FROM favourites WHERE favourites_id=" . $id;
        $result = $db->query($strSQL);
        $arrFetchFavourites = $result->fetchAll();
        $arrFavourites = json_decode(json_encode($arrFetchFavourites, JSON_THROW_ON_ERROR), true, 512,
            JSON_THROW_ON_ERROR);
        $arrFavourite = array_shift($arrFavourites);

        // create object
        $oFavourites = new self();
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
     * @throws JsonException
     */
    public static function getInstance(?int $id = null): Favourites
    {
        if (is_null($id)) {
            return new self();
        }

        return self::loadFromDB($id);
    }

    /**
     * @return Favourites[]
     * @throws QueryException
     * @throws JsonException
     */
    public static function getInstances(): array
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM favourites");
        $arrFetchFavourites = $result->fetchAll();
        $arrTmp = json_decode(json_encode($arrFetchFavourites, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
        $arrInstances = [];
        foreach ($arrTmp as $arrFavourite) {
            $oFavourite = self::getInstance($arrFavourite["favourites_id"]);
            $arrInstances[$oFavourite->getFavouritesId()] = $oFavourite;
        }
        return $arrInstances;
    }

    /**
     * @return array
     * @throws QueryException
     * @throws JsonException
     * @noinspection PhpUnused
     */
    public function getFavourites(): array
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM favourites");
        $arrFetchFavourites = $result->fetchAll();
        return json_decode(json_encode($arrFetchFavourites, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return array
     * @throws QueryException
     * @throws JsonException
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
    public function save(): void
    {

        $id = $this->getFavouritesId() ?: null;
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
