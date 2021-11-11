<?php /** @noinspection PhpUnused */

namespace App;
use App\Classes\Bookmarks;
use App\Classes\Categories;
use App\Classes\Favourites;
use App\Classes\Helper;
use Exception;
use Jaxon\Exception\Error;
use Jaxon\Jaxon;
use Jaxon\Response\Response;
use Smarty;
use SmartyException;
use voku\db\exceptions\QueryException;

#use voku\db\DB;
#use ParseCsv\Csv;

#use Monolog\Logger;
#use Monolog\Handler\StreamHandler;


class AppController
{
    /**
     * index
     *
     * @return void
     * @throws QueryException
     * @throws SmartyException
     */
    public function index()
    {
        $oCategories = new Categories();
        $aCategories = $oCategories->getInstances();

        $oBookmarks = new Bookmarks();
        $aBookmarks = $oBookmarks->getInstances();

        $smarty = new Smarty;
        $smarty->assign('ARR_BOOKMARKS', $aBookmarks);
        $smarty->assign('ARR_CATEGORIES', $aCategories);
        $smarty->display('templates/index.tpl');
    }

    /**
     * topBookmarks
     *
     * @return void
     * @throws QueryException|SmartyException
     */
    public function topBookmarks()
    {
        $oBookmarks = new Bookmarks();
        $aTopBookmarks = $oBookmarks->getTopBookmarks();
        $smarty = new Smarty;
        $smarty->assign('ARR_BOOKMARKS_TOP', $aTopBookmarks);
        $smarty->display('templates/top_bookmarks.tpl');
    }

    /**
     * favourites
     *
     * @return void
     * @throws QueryException|SmartyException
     */
    public function favourites()
    {
        $oFavourites = new Favourites();
        $aFavourites = $oFavourites->getInstances();
        $smarty = new Smarty;
        $smarty->assign('ARR_FAVOURITES', $aFavourites);
        $smarty->display('templates/favourites.tpl');
    }


    /**
     * addCategory
     *
     * @return void
     * @throws QueryException|SmartyException
     */
    public function addCategory()
    {

        $strAppNotifyMsg = "";

        if (isset($_POST["category_parent"])) {

            $intCategoryParent = Helper::sanitizeInteger($_POST["category_parent"]);
            $strCategoryName = Helper::sanitizeString($_POST["category_name"]);

            $oCategory = Categories::getInstance();
            $oCategory->setCategoriesParent($intCategoryParent);
            $oCategory->setCategoriesName($strCategoryName);
            $oCategory->save();
            $strAppNotifyMsg = "Added new Category";
        }

        $oCategories = new Categories();
        $categories = $oCategories->getCategories();

        $smarty = new Smarty;
        $smarty->assign('APP_NOTIFY_MESSAGE', $strAppNotifyMsg);
        $smarty->assign('CATEGORIES', $categories);
        $smarty->display('templates/add_category.tpl');
    }


    /**
     * editCategory
     *
     * @return void
     * @throws QueryException|SmartyException
     * @throws Exception
     */
    public function editCategory()
    {
        $strAppNotifyMsg = "";

        if (isset($_POST["category_id"])) {

            $intCategoryId = Helper::sanitizeInteger($_POST["category_id"]);
            $intCategoryParent = Helper::sanitizeInteger($_POST["category_parent"]);
            $strCategoryName = Helper::sanitizeString($_POST["category_name"]);

            if ($intCategoryId == $intCategoryParent) {
                throw new Exception("Parent category is identical with category");
            }

            $oCategory = Categories::getInstance($intCategoryId);
            $oCategory->setCategoriesParent($intCategoryParent);
            $oCategory->setCategoriesName($strCategoryName);
            $oCategory->save();
            $strAppNotifyMsg = "Edited Category";
        }


        $oCategories = new Categories();
        $categories = $oCategories->getCategories();

        $oCategory = Categories::getInstance((int)$_GET["id"]);

        $smarty = new Smarty;
        $smarty->assign('APP_NOTIFY_MESSAGE', $strAppNotifyMsg);
        $smarty->assign('CATEGORIES', $categories);
        $smarty->assign('OBJ_CATEGORY', $oCategory);
        $smarty->display('templates/edit_category.tpl');
    }


    /**
     * addBookmark
     *
     * @return void
     * @throws QueryException|SmartyException
     */
    public function addBookmark()
    {

        $strAppNotifyMsg = "";

        if (isset($_POST["bookmark_category"])) {

            $intBookmarkCategory = $_POST["bookmark_category"];
            $strBookmarkName = $_POST["bookmark_name"];
            $strBookmarkUrl = $_POST["bookmark_url"];
            $strBookmarkType = $_POST["bookmark_type"];

            $oBookmark = new Bookmarks();
            $oBookmark->setCategoriesId($intBookmarkCategory);
            $oBookmark->setBookmarksHash(time());
            $oBookmark->setBookmarksName($strBookmarkName);
            $oBookmark->setBookmarksUrl($strBookmarkUrl);
            $oBookmark->setBookmarksType($strBookmarkType);
            $oBookmark->save();
            $strAppNotifyMsg = "Added new Bookmark";
        }

        $oCategories = new Categories();
        $categories = $oCategories->getCategories();

        $smarty = new Smarty;
        $smarty->assign('APP_NOTIFY_MESSAGE', $strAppNotifyMsg);
        $smarty->assign('CATEGORIES', $categories);
        $smarty->display('templates/add_bookmark.tpl');
    }


    /**
     * editBookmark
     *
     * @return void
     * @throws QueryException|SmartyException
     */
    public function editBookmark()
    {
        $strAppNotifyMsg = "";


        if (isset($_POST["bookmark_id"])) {

            $intBookmarkCategory = $_POST["bookmark_category"];
            $strBookmarkName = $_POST["bookmark_name"];
            $strBookmarkUrl = $_POST["bookmark_url"];
            $strBookmarkType = $_POST["bookmark_type"];

            $oBookmark = Bookmarks::getInstance($_POST["bookmark_id"]);
            $oBookmark->setCategoriesId($intBookmarkCategory);
            $oBookmark->setBookmarksHash(time());
            $oBookmark->setBookmarksName($strBookmarkName);
            $oBookmark->setBookmarksUrl($strBookmarkUrl);
            $oBookmark->setBookmarksType($strBookmarkType);
            $oBookmark->save();
            $strAppNotifyMsg = "Edited Bookmark";
        }

        $oCategories = new Categories();
        $categories = $oCategories->getCategories();
        $oBookmark = Bookmarks::getInstance((int)$_GET["id"]);

        $smarty = new Smarty;
        $smarty->assign('APP_NOTIFY_MESSAGE', $strAppNotifyMsg);
        $smarty->assign('CATEGORIES', $categories);
        $smarty->assign('OBJ_BOOKMARK', $oBookmark);
        $smarty->display('templates/edit_bookmark.tpl');
    }

    /**
     * @throws QueryException|SmartyException
     */
    public function viewBookmark(){

        $strAppNotifyMsg = "";

        $oCategories = new Categories();
        $categories = $oCategories->getCategories();
        $oBookmark = Bookmarks::getInstance((int)$_GET["id"]);

        $smarty = new Smarty;
        $smarty->assign('APP_NOTIFY_MESSAGE', $strAppNotifyMsg);
        $smarty->assign('CATEGORIES', $categories);
        $smarty->assign('OBJ_BOOKMARK', $oBookmark);
        $smarty->display('templates/view_bookmark.tpl');
    }


    /**
     * @throws QueryException
     */
    public function removeCategory($intId): Response
    {

        $oCategories = Categories::getInstance($intId);
        $oCategories->delete();

        $response = new Response();
        #$response->jQuery('#message')->html('Yaba daba doo')->css('color', 'blue');
        $response->jQuery('#row_cat_' . $intId . '')->remove();
        $response->alert("deleted " . $intId);
        return $response;
    }

    /**
     * @throws QueryException
     */
    public function removeBookmark($intId): Response
    {

        $oBookmark = Bookmarks::getInstance($intId);
        $oBookmark->delete();

        $response = new Response();
        $response->jQuery('#row_book_' . $intId . '')->remove();
        $response->alert("deleted " . $intId);
        return $response;
    }

    /**
     * @throws QueryException
     */
    public function removeFavourite($intId): Response
    {

        $oFavourite = Favourites::getInstance($intId);
        $oFavourite->delete();

        $response = new Response();
        $response->jQuery('#row_fav_' . $intId . '')->remove();
        $response->alert("deleted " . $intId);
        return $response;
    }

    /**
     * @throws QueryException
     */
    public function addFavourite($intBookmarkId): Response
    {
        $oFavourite = new Favourites();
        $oFavourite->setBookmarksId($intBookmarkId);
        $oFavourite->save();

        $response = new Response();
        $response->alert("Added to favs " . $intBookmarkId);
        return $response;
    }


    /**
     * @throws QueryException
     */
    public function exportBookmarks(): void
    {
        Bookmarks::getBookmarksAsCSV();
    }


    /**
     * @param $isCaps
     * @return Response
     */
    public function sayHello($isCaps): Response
    {

        /*
        $log = new Logger('name');
        $log->pushHandler(
            new StreamHandler(
                APP_ROOT_YBMA . '/debugger.log',
                Logger::WARNING
            )
        );
        // add records to the log
        $log->warning($intId . " " . time());
        */

        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response = new Response();
        $response->alert($text);
        return $response;
    }
}

// Get the core singleton object
$jaxon = jaxon();
// Register an instance of the class with Jaxon
$jaxon->register(Jaxon::CALLABLE_OBJECT, new AppController()); // v2.x
// Call the Jaxon processing engine
try {
    $jaxon->processRequest();
} catch (Error $e) {
    echo $e->getMessage();
}
