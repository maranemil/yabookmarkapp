{include file='../templates/page_header.tpl'}


<div class="row">
    <div class="rounded col-sm-12 p-sm-3">
        <h3 class="bolder white ml-3">Add Category</h3>
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
                        <select name="category_parent">
                            {foreach from=$CATEGORIES item=item key=key name=name}
                                <option value="{$item.categories_id}">
                                    {$item.categories_name}
                                </option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Category Name</td>
                    <td>
                        <input type="text" name="category_name" required>
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