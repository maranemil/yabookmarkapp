{include file='../templates/page_header.tpl'}


<div class="row">
    <div class=" rounded  col-sm-12  p-sm-3">
        <h3 class="bolder white ml-3">Add Bookmark</h3>
    </div>
</div>

<div class="content">
    <div class="col-sm-12">

        {$APP_NOTIFY_MESSAGE}

        <form method="POST">
            <table class="table table-striped table-bordered table-hover table-sm">
                <tr>
                    <td class="col-sm-4">Bookmark Category</td>
                    <td>
                        <label>
                            <select name="bookmark_category">
                                {foreach from=$CATEGORIES item=item key=key name=name}
                                    <option value="{$item.categories_id}">
                                        {$item.categories_name}
                                    </option>
                                {/foreach}
                            </select>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Bookmark Name</td>
                    <td>
                        <label>
                            <input type="text" name="bookmark_name" required
                                   class="w-100">
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Bookmark Url</td>
                    <td>
                        <label>
                            <textarea name="bookmark_url" required class="w-100" style="height: 150px;"></textarea>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Bookmark Type</td>
                    <td>
                        <label>
                            <select name="bookmark_type" required>
                                {foreach from=Bookmarks::arrBookmarkType item=item key=key name=name}
                                    <option value="{$key}">{$item}</option>
                                {/foreach}
                            </select>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="save" value="Save" 
                               class="btn btn-primary btn-sm">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>



{include file='../templates/page_footer.tpl'}