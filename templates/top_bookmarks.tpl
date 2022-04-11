{include file='../templates/page_header.tpl'}

<div class="row">
    <div class="rounded col-sm-12 p-sm-4">
        <h3 class="bolder white ml-3">Top Bookmarks</h3>
    </div>
</div>

<section class="content">
    <div class="rounded col-sm-12 p-sm-3">
        {foreach from=$ARR_BOOKMARKS_TOP item=ARR_ITEM}
            {if $ARR_ITEM.total > 1}
                <div class=" col-4 pull-left">
                    <div class="alert alert-info p-2">
                        <span class="badge badge-dark badge-pill">{$ARR_ITEM.total} </span> 
                        <a href="{$ARR_ITEM.url}" target="_blank" class="text-dark">{$ARR_ITEM.url}</a>
                    </div>
                </div>
            {/if}
        {/foreach}
    </div>
</section>

{include file='../templates/page_footer.tpl'}