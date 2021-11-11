<?php
namespace App\Classes;
#use Database;
use voku\db\exceptions\QueryException;

class Categories
{
    
    /**
     * intCategoriesId
     *
     * @var int
     */
    private int $intCategoriesId = 0;
    /**
     * intCategoriesParent
     *
     * @var int
     */
    private int $intCategoriesParent = 0;
    /**
     * strCategoriesName
     *
     * @var string
     */
    private string $strCategoriesName = '';
    
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
    public function setCategoriesId(int $intCategoriesId)
    {
        $this->intCategoriesId = $intCategoriesId;
    }    
    /**
     * getCategoriesParent
     *
     * @return int
     */
    public function getCategoriesParent(): int
    {
        return $this->intCategoriesParent;
    }    
    /**
     * setCategoriesParent
     *
     * @param int $intCategoriesParent
     * @return void
     */
    public function setCategoriesParent(int $intCategoriesParent)
    {
        $this->intCategoriesParent = $intCategoriesParent;
    }    
    /**
     * getCategoriesName
     *
     * @return string
     */
    public function getCategoriesName(): string
    {
        return Helper::sanitizeString($this->strCategoriesName);
    }    
    /**
     * setCategoriesName
     *
     * @param string $strCategoriesName
     * @return void
     */
    public function setCategoriesName(string $strCategoriesName)
    {
        $this->strCategoriesName = Helper::sanitizeString($strCategoriesName);
    }

    /**
     * @param $id
     * @return Categories
     * @throws QueryException
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
     * @param null $id
     * @return Categories
     * @throws QueryException
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
     * @throws QueryException
     */
    public static function getInstances(): array
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM categories");
        $arrFetchCategories  = (array)$result->fetchAll();
        $arrTmp = json_decode(json_encode($arrFetchCategories), true);
        $arrInstances = [];
        foreach ($arrTmp as $arrCategory) {
            $oCategory = Categories::getInstance($arrCategory["categories_id"]);
            $arrInstances[$oCategory->getCategoriesId()] = $oCategory;
        }
        return $arrInstances;
    }

    /**
     * @return array
     * @throws QueryException
     * @noinspection PhpUnused
     */
    public function getCategories(): array
    {
        $db = Database::init();
        $result = $db->query("SELECT * FROM categories");
        $arrFetchCategories  = (array)$result->fetchAll();
        return json_decode(json_encode($arrFetchCategories), true);
    }

    /**
     * @description - save and update
     * @throws QueryException
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
     * @throws QueryException
     */
    public function delete(): void
    {
        $db = Database::init();
        $strSQL = "DELETE FROM  `categories` 
            WHERE categories_id=  " . $this->getCategoriesId();
        $db->execSQL($strSQL);
    }
}
