<?php

use Database;

class Categories
{
    
    /**
     * intCategoriesId
     *
     * @var undefined
     */
    private $intCategoriesId = null;    
    /**
     * intCategoriesParent
     *
     * @var undefined
     */
    private $intCategoriesParent = null;    
    /**
     * strCategoriesName
     *
     * @var undefined
     */
    private $strCategoriesName = null;
    
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
     * getCategoriesParent
     *
     * @return void
     */
    public function getCategoriesParent()
    {
        return $this->intCategoriesParent;
    }    
    /**
     * setCategoriesParent
     *
     * @param  mixed $intCategoriesParent
     * @return void
     */
    public function setCategoriesParent($intCategoriesParent)
    {
        $this->intCategoriesParent = $intCategoriesParent;
    }    
    /**
     * getCategoriesName
     *
     * @return void
     */
    public function getCategoriesName()
    {
        return Helper::sanitizeString($this->strCategoriesName);
    }    
    /**
     * setCategoriesName
     *
     * @param  mixed $strCategoriesName
     * @return void
     */
    public function setCategoriesName($strCategoriesName)
    {
        $this->strCategoriesName = Helper::sanitizeString($strCategoriesName);
    }

    /**
     * @return Categories
     */
    public static function loadFromDB($id): Categories
    {
        $db = Database::init();
        $strSQL = "SELECT * FROM categories WHERE categories_id=" . $id;
        $result = $db->query($strSQL);
        $arrFetchCategories  = (array)$result->fetchAll();
        $arrCategories = json_decode(json_encode($arrFetchCategories), true);
        $arrCategory = array_shift($arrCategories);

        // create object
        $oCategories = new Categories();
        $oCategories->setCategoriesId($arrCategory["categories_id"]);
        $oCategories->setCategoriesParent($arrCategory["categories_parent"]);
        $oCategories->setCategoriesName($arrCategory["categories_name"]);

        return $oCategories;
    }

    /**
     * @return Categories
     */
    public static function getInstance($id = null): Categories
    {
        if (is_null($id)) {
            return new Categories();
        } else {
            return self::loadFromDB($id);
        }
    }

    /**
     * @return Categories[]
     */
    public static function getInstances()
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM categories");
        $arrFetchCategories  = (array)$result->fetchAll();
        $arrTmp = json_decode(json_encode($arrFetchCategories), true);
        foreach ($arrTmp as $arrCategory) {
            $oCategory = Categories::getInstance($arrCategory["categories_id"]);
            $arrInstances[$oCategory->getCategoriesId()] = $oCategory;
        }
        return $arrInstances;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM categories");
        $arrFetchCategories  = (array)$result->fetchAll();
        return json_decode(json_encode($arrFetchCategories), true);
    }

    /**
     * @description - save and upate
     */
    public function save()
    {

        $id = $this->getCategoriesId() ?? 'NULL';
        $db = Database::init();

        $strSQL = "INSERT INTO `categories`         
                (
                    `categories_id`,
                    `categories_parent`,
                    `categories_name`
                )
                VALUES(
                    " . $id . ",
                    " . $this->getCategoriesParent() . ",
                    '" . $this->getCategoriesName() . "'
                )
                ON DUPLICATE KEY UPDATE
                    `categories_parent` = " . $this->getCategoriesParent() . ",
                    `categories_name` = '" . $this->getCategoriesName() . "'
                ";
        $db->execSQL($strSQL);
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $db = Database::init();
        $strSQL = "DELETE FROM  `categories` 
            WHERE categories_id=  " . $this->getCategoriesId();
        $db->execSQL($strSQL);
    }
}
