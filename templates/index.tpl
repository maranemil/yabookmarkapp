{include file='../templates/page_header.tpl'}

<div class="row">
    <div class="rounded col-sm-12 p-sm-3">
        <h3 class="bolder white ml-3">Bookmarks / Categories</h3>
    </div>
</div>

<div class="tabs">
    <div class="tab-button-outer">
        <ul id="tab-button">
            <li><a href="#tab01">Bookmarks</a></li>
            <li><a href="#tab02">Categories</a></li>
        </ul>
    </div>
    <div class="tab-select-outer">
        <label for="tab-select"></label><select id="tab-select">
            <option value="#tab01">Bookmarks</option>
            <option value="#tab02">Categories</option>
        </select>
    </div>

    <div id="tab01" class="tab-contents">

        <table class="table table-striped table-bordered table-hover table-sm" id="dataTable_bookmarks">
            <thead class="thead-dark">
                <tr class="table-active">
                    <th class="table-dark">ID</th>
                    <th class="table-dark col-sm-2">Category ID</th>
                    <th class="table-dark">Hash</th>
                    <th class="table-dark">Name</th>
                    <th class="table-dark">Fav</th>
                    <th class="table-dark no-sort">Urls</th>
                    <th class="table-dark">Type</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                {assign var="ARR_KEYS_FAVS" value=App\Classes\Favourites::getFavouritesBookmarks()}
                {foreach $ARR_BOOKMARKS as $OBJ_BOOKMARK}
                    <tr id="row_book_{$OBJ_BOOKMARK->getBookmarksId()}">
                        <td>
                            {$OBJ_BOOKMARK->getBookmarksId()}
                        </td>
                        <td>
                            {App\Classes\Categories::getInstance($OBJ_BOOKMARK->getCategoriesId())->getCategoriesName()}
                        </td>
                        <td>
                            {$OBJ_BOOKMARK->getBookmarksHash()|date_format:'%d.%m.%Y'}
                        </td>
                        <td class="wrap">
                            {$OBJ_BOOKMARK->getBookmarksName()|capitalize}
                        </td>
                        <td>
                            {if in_array($OBJ_BOOKMARK->getBookmarksId(),$ARR_KEYS_FAVS)}
                                <span class="badge badge-pill badge-warning">
                                    <i class="fa fa-bookmark" aria-hidden="true"></i>
                                </span>
                            {else}
                                <a href="#"
                                    onclick="JaxonAppController.addFavourite({$OBJ_BOOKMARK->getBookmarksId()});return false;">
                                    <span class="badge badge-pill badge-info">
                                        <i class="fa fa-bookmark-o" aria-hidden="true"></i>
                                    </span>
                                </a>
                            {/if}
                        </td>
                        <td class="text-center">
                            {if (substr_count($OBJ_BOOKMARK->getBookmarksUrl(), "http") == 1)}
                                <a href="{$OBJ_BOOKMARK->getBookmarksUrl()}" target="_blank" class="text-info">
                                    <i class="fa fa-link"></i>
                                </a>
                            {else}
                                <a href="view_bookmark.php?id={$OBJ_BOOKMARK->getBookmarksId()}" target="_blank" class="text-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                            {/if}
                        </td>
                        <td>{App\Classes\Bookmarks::getTypeAsString($OBJ_BOOKMARK->getBookmarksType())}</td>
                        <td class="text-center text-nowrap">
                            <a href="view_bookmark.php?id={$OBJ_BOOKMARK->getBookmarksId()}" target="_blank" class="text-info">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="edit_bookmark.php?id={$OBJ_BOOKMARK->getBookmarksId()}" class="text-info">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" class="text-info"
                                onclick="JaxonAppController.removeBookmark({$OBJ_BOOKMARK->getBookmarksId()});return false;">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>

    </div>
    <div id="tab02" class="tab-contents">

        <table class="table table-striped table-bordered table-hover table-sm" id="dataTable_categories">
            <thead class="thead-dark">
                <tr class="table-active">
                    <th class="table-dark">ID</th>
                    <th class="table-dark">Parent ID</th>
                    <th class="table-dark">Name</th>
                    <th class="table-dark"></th>

                </tr>
            </thead>
            <tbody>
                {foreach $ARR_CATEGORIES as $OBJ_CATEGORY}
                    <tr id="row_cat_{$OBJ_CATEGORY->getCategoriesId()}">
                        <td>{$OBJ_CATEGORY->getCategoriesId()}</td>
                        <td>{$OBJ_CATEGORY->getCategoriesParent()}</td>
                        <td>{$OBJ_CATEGORY->getCategoriesName()}</td>
                        <td class="text-center text-nowrap">
                            <a href="edit_category.php?id={$OBJ_CATEGORY->getCategoriesId()}" class="text-info">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" class="text-info"
                                onclick="JaxonAppController.removeCategory({$OBJ_CATEGORY->getCategoriesId()});return false;">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>

{* <div class="row mt-4">
    <div class="col-sm-12">

    </div>
</div>
<div class="row mt-4">
    <div class="col-sm-12">

    </div>
</div> *}

{include file='../templates/page_footer.tpl'}