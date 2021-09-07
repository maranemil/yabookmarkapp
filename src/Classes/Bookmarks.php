<?php

use Database;

class Bookmarks
{

    /**
     * const
     */
    public const arrBookmarkType = [
        0 => "bookmark",
        2 => "notice",
        1 => "collection",
    ];

    /**
     * intBookmarksId
     *
     * @var undefined
     */
    private $intBookmarksId = null;
    /**
     * intCategoriesId
     *
     * @var undefined
     */
    private $intCategoriesId = null;
    /**
     * strBookmarksHash
     *
     * @var undefined
     */
    private $strBookmarksHash = null;
    /**
     * strBookmarksName
     *
     * @var undefined
     */
    private $strBookmarksName = null;
    /**
     * strBookmarksUrl
     *
     * @var undefined
     */
    private $strBookmarksUrl = null;
    /**
     * intBookmarksType
     *
     * @var undefined
     */
    private $intBookmarksType = null;

    /**
     * getBookmarksId
     *
     * @return void
     */
    public function getBookmarksId()
    {
        return $this->intBookmarksId;
    }
    /**
     * setBookmarksId
     *
     * @param  mixed $intBookmarksId
     * @return void
     */
    public function setBookmarksId($intBookmarksId)
    {
        $this->intBookmarksId = $intBookmarksId;
    }
    /**
     * getCategoriesId
     *
     * @return void
     */
    public function getCategoriesId()
    {
        return $this->intCategoriesId;
    }
    /**
     * setCategoriesId
     *
     * @param  mixed $intCategoriesId
     * @return void
     */
    public function setCategoriesId($intCategoriesId)
    {
        $this->intCategoriesId = $intCategoriesId;
    }
    /**
     * getBookmarksHash
     *
     * @return void
     */
    public function getBookmarksHash()
    {
        return $this->strBookmarksHash;
    }
    /**
     * setBookmarksHash
     *
     * @param  mixed $strBookmarksHash
     * @return void
     */
    public function setBookmarksHash($strBookmarksHash)
    {
        $this->strBookmarksHash = $strBookmarksHash;
    }
    /**
     * getBookmarksName
     *
     * @return void
     */
    public function getBookmarksName()
    {
        return Helper::sanitizeString($this->strBookmarksName);
    }
    /**
     * setBookmarksName
     *
     * @param  mixed $strBookmarksName
     * @return void
     */
    public function setBookmarksName($strBookmarksName)
    {
        $this->strBookmarksName = Helper::sanitizeString($strBookmarksName);
    }
    /**
     * getBookmarksUrl
     *
     * @return void
     */
    public function getBookmarksUrl()
    {
        return Helper::sanitizeUrl($this->strBookmarksUrl);
    }
    /**
     * setBookmarksUrl
     *
     * @param  mixed $strBookmarksUrl
     * @return void
     */
    public function setBookmarksUrl($strBookmarksUrl)
    {
        $this->strBookmarksUrl = Helper::sanitizeUrl($strBookmarksUrl);
    }
    /**
     * getBookmarksType
     *
     * @return void
     */
    public function getBookmarksType()
    {
        return $this->intBookmarksType;
    }
    /**
     * setBookmarksType
     *
     * @param  mixed $intBookmarksType
     * @return void
     */
    public function setBookmarksType($intBookmarksType)
    {
        $this->intBookmarksType = $intBookmarksType;
    }

    /**
     * @return Bookmarks
     */
    public static function loadFromDB($id): Bookmarks
    {
        $db = Database::init();
        $strSQL = "SELECT * FROM bookmarks WHERE bookmarks_id=" . $id;
        $result = $db->query($strSQL);
        $arrFetchBookmarks  = (array)$result->fetchAll();
        $arrBookmarks = json_decode(json_encode($arrFetchBookmarks), true);
        $arrBookmark = array_shift($arrBookmarks);

        // create object
        $oBookmark = new Bookmarks();
        $oBookmark->setBookmarksId($arrBookmark["bookmarks_id"]);
        $oBookmark->setCategoriesId($arrBookmark["categories_id"]);
        $oBookmark->setBookmarksHash($arrBookmark["bookmarks_hash"]);
        $oBookmark->setBookmarksName($arrBookmark["bookmarks_name"]);
        $oBookmark->setBookmarksUrl($arrBookmark["bookmarks_url"]);
        $oBookmark->setBookmarksType($arrBookmark["bookmarks_type"]);

        return $oBookmark;
    }

    /**
     * @return Bookmarks
     */
    public static function getInstance($id = null): Bookmarks
    {
        if (is_null($id)) {
            return new Bookmarks();
        } else {
            return self::loadFromDB($id);
        }
    }

    /**
     * @return Bookmarks[]
     */
    public static function getInstances()
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM bookmarks");
        $arrFetchBookmarks  = (array)$result->fetchAll();
        $arrTmp = json_decode(json_encode($arrFetchBookmarks), true);
        foreach ($arrTmp as $arrBookmark) {
            $oBookmark = Bookmarks::getInstance($arrBookmark["bookmarks_id"]);
            $arrInstances[$oBookmark->getBookmarksId()] = $oBookmark;
        }
        return $arrInstances;
    }

    /**
     * getBookmarks
     *
     * @return array
     */
    public function getBookmarks(): array
    {

        $db = Database::init();
        $result = $db->query("SELECT * FROM bookmarks");
        $arrFetchBookmarks  = (array)$result->fetchAll();
        return json_decode(json_encode($arrFetchBookmarks), true);
    }


    /**
     * getTopBookmarks
     *
     * @return void
     */
    public function getTopBookmarks()
    {
        $db = Database::init();
        $result = $db->query("SELECT SUBSTRING_INDEX(bookmarks_url, '/', 3) AS url ,count(*) AS total FROM `bookmarks` GROUP BY url ORDER BY total DESC;");
        $arrFetchBookmarks  = (array)$result->fetchAll();
        return json_decode(json_encode($arrFetchBookmarks), true);
    }




    /**
     * getTypeAsString
     *
     * @param  mixed $intType
     * @return string
     */
    public static function getTypeAsString($intType): string
    {
        return self::arrBookmarkType[$intType];
    }

    /**
     * getBookmarksAsCSV
     *
     * @return void
     */
    public static function getBookmarksAsCSV()
    {

        // Read CSV
        // $csv = new \ParseCsv\Csv();
        // $csv->auto('data.csv');
        // print_r($csv->data);

        $oBookmarks = Bookmarks::getInstances();
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
        $csv = new \ParseCsv\Csv();
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
     * @description - save and upate
     */
    public function save()
    {

        $id = $this->getBookmarksId() ?? 'NULL';
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
     */
    public function delete(): void
    {
        $db = Database::init();
        $strSQL = "DELETE FROM  `bookmarks` 
                WHERE bookmarks_id=  " . $this->getBookmarksId();
        $db->execSQL($strSQL);
    }
}
