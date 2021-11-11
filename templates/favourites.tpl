{include file='../templates/page_header.tpl'}

<div class="row">
    <div class="rounded col-sm-12 p-sm-3">
        <h3 class="bolder white ml-3">Favourites</h3>
    </div>
</div>

<section class="content">
    <div class="rounded col-sm-12 p-sm-3">

        <table class="table table-striped table-bordered table-hover table-sm" id="dataTable_favs">
            <thead class="thead-dark">
                <tr class="table-active">
                    <th class="table-dark">ID</th>
                    <th class="table-dark col-sm-2">Bookmarks ID</th>
                    <th>Bookmarks Name</th>
                    <th>Bookmarks Urls</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$ARR_FAVOURITES item=OBJ_FAVOURITES key=key name=name}
                    <tr id="row_fav_{$OBJ_FAVOURITES->getFavouritesId()}">
                        <td>
                            {$OBJ_FAVOURITES->getFavouritesId()}
                        </td>
                        <td>
                            {$OBJ_FAVOURITES->getBookmarksId()}
                        </td>
                        <td>
                            {App\Classes\Bookmarks::getInstance($OBJ_FAVOURITES->getBookmarksId())->getBookmarksName()}
                        </td>
                        <td>
                            {assign var='URLS' value=explode('http',App\Classes\Bookmarks::getInstance($OBJ_FAVOURITES->getBookmarksId())->getBookmarksUrl())}

                            {foreach from=$URLS item=item name=name}
                                {if !empty($item)}
                                    <a href="{$item|replace:'s:':''}" class="text-info"
                                       target="_blank">
                                        <i class="fa fa-link"></i>
                                    </a>
                                {/if}
                            {/foreach}

                        </td>
                        <td class="text-center text-nowrap">                            
                            <a href="#" class="text-info"
                               onclick="JaxonAppController.removeFavourite({$OBJ_FAVOURITES->getFavouritesId()});
                                        return false;">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</section>

{include file='../templates/page_footer.tpl'}