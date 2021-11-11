{include file='../templates/page_header.tpl'}


<div class="row">
    <div class=" rounded  col-sm-12  p-sm-3">
        <h3 class="bolder white ml-3">Edit Category</h3>
    </div>
</div>

<div class="content">
    <div class="col-sm-12">

        {$APP_NOTIFY_MESSAGE}

        <form method="POST">
            <table class="table table-striped table-bordered table-hover table-sm">
                <tr>
                    <td>Category Parent</td>
                    <td>
                        <label>
                            <select name="category_parent">
                                {foreach from=$CATEGORIES item=item key=key name=name}
                                    <option value="{$item.categories_id}"
                                            {if $OBJ_CATEGORY->getCategoriesParent() eq $item.categories_id}selected{/if}>
                                        {$item.categories_name}
                                    </option>
                                {/foreach}
                            </select>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Category Name</td>
                    <td>
                        <label>
                            <input type="text" name="category_name"
                                   required value="{$OBJ_CATEGORY->getCategoriesName()}">
                        </label>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="category_id" value="{$OBJ_CATEGORY->getCategoriesId()}">
                        <input type="submit" name="save" value="Save" class="btn btn-primary btn-sm">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

{include file='../templates/page_footer.tpl'}