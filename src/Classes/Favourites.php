<?php

class Favourites
{

    private $iFavouritesId = null;
    private $iBookmarksId = null;

    public function getFavouritesId()
    {
        return $this->iFavouritesId;
    }
    public function setFavouritesId($iFavouritesId)
    {
        $this->iFavouritesId = $iFavouritesId;
    }

    public function getBookmarksId()
    {
        return $this->iBookmarksId;
    }
    public function setBookmarksId($iBookmarksId)
    {
        $this->iBookmarksId = $iBookmarksId;
    }

    /**
     * loadFromDB
     *
     * @param  mixed $id
     * @return Favourites
     */
    public static function loadFromDB($id): Favourites
    {
        $db = Database::init();
        $strSQL = "SELECT * FROM favourites WHERE favourites_id=" . $id;
        $result = $db->query($strSQL);
        $arrFetchFavourites  = (array)$result->fetchAll();
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
     * @param  mixed $id
     * @return Favourites
     */
    public static function getInstance($id = null): Favourites
    {
        if (is_null($id)) {
            return new Favourites();
        } else {
            return self::loadFromDB($id);
        }
    }

    /**
     * @return Favourites[]
     */
    public static function getInstances()
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM favourites");
        $arrFetchFavourites  = (array)$result->fetchAll();
        $arrTmp = json_decode(json_encode($arrFetchFavourites), true);
        foreach ($arrTmp as $arrFavourite) {
            $oFavourite = Favourites::getInstance($arrFavourite["favourites_id"]);
            $arrInstances[$oFavourite->getFavouritesId()] = $oFavourite;
        }
        return $arrInstances;
    }

    /**
     * @return array
     */
    public function getFavourites()
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM favourites");
        $arrFetchFavourites  = (array)$result->fetchAll();
        return json_decode(json_encode($arrFetchFavourites), true);
    }

    public static function getFavouritesBookmarks(){
        $aFavourites = self::getInstances();
        foreach($aFavourites as $oFavourite){
            $aFavBookmarks[$oFavourite->getBookmarksId()] = $oFavourite->getBookmarksId();
        }
        return $aFavBookmarks;
    }

    /**
     * @description - save and upate
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
     */
    public function delete(): void
    {
        $db = Database::init();
        $strSQL = "DELETE FROM  `favourites` 
            WHERE favourites_id=  " . $this->getFavouritesId();
        $db->execSQL($strSQL);
    }

}
