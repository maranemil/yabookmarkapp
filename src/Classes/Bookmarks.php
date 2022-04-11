<?php

/** @noinspection PhpUnused */
/** @noinspection PhpMultipleClassDeclarationsInspection */
/** @noinspection SqlDialectInspection */
/** @noinspection StaticInvocationViaThisInspection */


namespace App\Classes;

#use Database;

use JetBrains\PhpStorm\Pure;
use JsonException;
use ParseCsv\Csv;
use voku\db\exceptions\QueryException;

class Bookmarks
{

    /**
     * const
     */
    public const arrBookmarkType
        = [
            0 => "bookmark",
            1 => "collection",
            2 => "notice",

        ];

    /**
     * intBookmarksId
     *
     * @var int
     */
    private int $intBookmarksId = 0;
    /**
     * intCategoriesId
     *
     * @var int
     */
    private int $intCategoriesId = 0;
    /**
     * strBookmarksHash
     *
     * @var string
     */
    private string $strBookmarksHash = '';
    /**
     * strBookmarksName
     *
     * @var string
     */
    private string $strBookmarksName = '';
    /**
     * strBookmarksUrl
     *
     * @var string
     */
    private string $strBookmarksUrl = '';
    /**
     * intBookmarksType
     *
     * @var int
     */
    private int $intBookmarksType = 0;

    /**
     * getBookmarksId
     *
     * @return int|null
     */
    public function getBookmarksId(): ?int
    {
        return $this->intBookmarksId;
    }

    /**
     * setBookmarksId
     *
     * @param mixed $intBookmarksId
     * @return void
     */
    public function setBookmarksId(mixed $intBookmarksId): void
    {
        $this->intBookmarksId = $intBookmarksId;
    }

    /**
     * getCategoriesId
     *
     * @return int
     */
    public function getCategoriesId(): int
    {
        return $this->intCategoriesId;
    }

    /**
     * setCategoriesId
     *
     * @param int $intCategoriesId
     * @return void
     */
    public function setCategoriesId(int $intCategoriesId): void
    {
        $this->intCategoriesId = $intCategoriesId;
    }

    /**
     * getBookmarksHash
     *
     * @return string
     */
    public function getBookmarksHash(): string
    {
        return $this->strBookmarksHash;
    }

    /**
     * setBookmarksHash
     *
     * @param string $strBookmarksHash
     * @return void
     */
    public function setBookmarksHash(string $strBookmarksHash): void
    {
        $this->strBookmarksHash = $strBookmarksHash;
    }

    /**
     * getBookmarksName
     *
     * @return string
     */
    public function getBookmarksName(): string
    {
        return Helper::sanitizeString($this->strBookmarksName);
    }

    /**
     * setBookmarksName
     *
     * @param string $strBookmarksName
     * @return void
     */
    public function setBookmarksName(string $strBookmarksName): void
    {
        $this->strBookmarksName = Helper::sanitizeString($strBookmarksName);
    }

    /**
     * getBookmarksUrl
     *
     * @return string
     */
    #[Pure] public function getBookmarksUrl(): string
    {
        return Helper::sanitizeUrl($this->strBookmarksUrl);
    }

    /**
     * setBookmarksUrl
     *
     * @param string $strBookmarksUrl
     */
    public function setBookmarksUrl(string $strBookmarksUrl): void
    {
        $this->strBookmarksUrl = Helper::sanitizeUrl($strBookmarksUrl);
    }

    /**
     * getBookmarksType
     *
     * @return int
     */
    public function getBookmarksType(): int
    {
        return $this->intBookmarksType;
    }

    /**
     * setBookmarksType
     *
     * @param int $intBookmarksType
     */
    public function setBookmarksType(int $intBookmarksType): void
    {
        $this->intBookmarksType = $intBookmarksType;
    }

    /**
     * @param $id
     * @return Bookmarks
     * @throws QueryException
     * @throws JsonException
     */
    public static function loadFromDB($id): Bookmarks
    {
        $db = Database::init();
        $strSQL = "SELECT * FROM bookmarks WHERE bookmarks_id=" . $id;
        $result = $db->query($strSQL);
        $arrFetchBookmarks = $result->fetchAll();
        $arrBookmarks = json_decode(json_encode($arrFetchBookmarks, JSON_THROW_ON_ERROR), true, 512,
            JSON_THROW_ON_ERROR);
        $arrBookmark = array_shift($arrBookmarks);

        // create object
        $oBookmark = new self();
        $oBookmark->setBookmarksId($arrBookmark["bookmarks_id"]);
        $oBookmark->setCategoriesId($arrBookmark["categories_id"]);
        $oBookmark->setBookmarksHash($arrBookmark["bookmarks_hash"]);
        $oBookmark->setBookmarksName($arrBookmark["bookmarks_name"]);
        $oBookmark->setBookmarksUrl($arrBookmark["bookmarks_url"]);
        $oBookmark->setBookmarksType($arrBookmark["bookmarks_type"]);

        return $oBookmark;
    }

    /**
     * @param int|null $id
     * @return Bookmarks
     * @throws QueryException
     * @throws JsonException
     */
    public static function getInstance(?int $id = null): Bookmarks
    {
        if (is_null($id)) {
            return new self();
        }

        return self::loadFromDB($id);
    }

    /**
     * @return Bookmarks[]
     * @throws QueryException|JsonException
     */
    public static function getInstances(): array
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM bookmarks");
        $arrFetchBookmarks = $result->fetchAll();
        $arrTmp = json_decode(json_encode($arrFetchBookmarks, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
        $arrInstances = [];
        foreach ($arrTmp as $arrBookmark) {
            $oBookmark = self::getInstance($arrBookmark["bookmarks_id"]);
            $arrInstances[$oBookmark->getBookmarksId()] = $oBookmark;
        }
        return $arrInstances;
    }

    /**
     * getBookmarks
     *
     * @return array
     * @throws QueryException
     * @throws JsonException
     * @noinspection PhpUnused
     */
    public function getBookmarks(): array
    {

        $db = Database::init();
        $result = $db->query("SELECT * FROM bookmarks");
        $arrFetchBookmarks = $result->fetchAll();
        return json_decode(json_encode($arrFetchBookmarks, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
    }


    /**
     * getTopBookmarks
     *
     * @return mixed
     * @throws QueryException
     * @throws JsonException
     */
    public function getTopBookmarks(): mixed
    {
        $db = Database::init();
        $result = $db->query("SELECT SUBSTRING_INDEX(bookmarks_url, '/', 3) AS url ,count(*) AS total FROM `bookmarks` GROUP BY url ORDER BY total DESC;");
        $arrFetchBookmarks = $result->fetchAll();
        return json_decode(json_encode($arrFetchBookmarks, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
    }


    /**
     * getTypeAsString
     *
     * @param int $intType
     * @return string
     * @noinspection PhpUnused
     */
    public static function getTypeAsString(int $intType): string
    {
        return self::arrBookmarkType[$intType];
    }

    /**
     * getBookmarksAsCSV
     *
     * @return void
     * @throws QueryException
     * @throws JsonException
     */
    public static function getBookmarksAsCSV(): void
    {

        // Read CSV
        // $csv = new \ParseCsv\Csv();
        // $csv->auto('data.csv');
        // print_r($csv->data);

        $data_array = [];
        $oBookmarks = self::getInstances();
        foreach ($oBookmarks as $oBookmark) {
            $data_array[] = array(
                $oBookmark->getBookmarksId(),
                $oBookmark->getCategoriesId(),
                $oBookmark->getBookmarksHash(),
                $oBookmark->getBookmarksName(),
                $oBookmark->getBookmarksUrl(),
                $oBookmark->getBookmarksType()
            );
        }

        // Write CSV
        $csv = new Csv();
        $csv->linefeed = "\n";
        $header = array(
            'bookmark_id',
            'category_id',
            'bookmark_hash',
            'bookmark_name',
            'bookmark_url',
            'bookmark_type'
        );
        $csv->output('bookmarks.csv', $data_array, $header, ',');
    }

    /**
     * @description - save and update
     * @throws QueryException
     */
    public function save(): void
    {

        $id = $this->getBookmarksId() ?: null;
        $db = Database::init();

        $strSQL = "INSERT INTO `bookmarks`         
                (
                    `bookmarks_id`,
                    `categories_id`,
                    `bookmarks_hash`,
                    `bookmarks_name`,
                    `bookmarks_url`,
                    `bookmarks_type`
                )
                VALUES(
                    " . $id . ",
                    " . $this->getCategoriesId() . ",
                    '" . $this->getBookmarksHash() . "',
                    '" . $this->getBookmarksName() . "',
                    '" . $this->getBookmarksUrl() . "',
                    '" . $this->getBookmarksType() . "'
                )
                ON DUPLICATE KEY UPDATE
                    `categories_id` = " . $this->getCategoriesId() . ",
                    `bookmarks_hash` = '" . $this->getBookmarksHash() . "',
                    `bookmarks_name` = '" . $this->getBookmarksName() . "',
                    `bookmarks_url` = '" . $this->getBookmarksUrl() . "',
                    `bookmarks_type` = '" . $this->getBookmarksType() . "'
                ";
        $db->execSQL($strSQL);
    }

    /**
     * delete
     *
     * @return void
     * @throws QueryException
     */
    public function delete(): void
    {
        $db = Database::init();
        $strSQL = "DELETE FROM  `bookmarks` 
                WHERE bookmarks_id=  " . $this->getBookmarksId();
        $db->execSQL($strSQL);
    }

    /**
     * @return string[]
     */
    public static function getBookmarkType(): array
    {
        return self::arrBookmarkType;
    }
}
