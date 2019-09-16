<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="search-page mt-3 mb-5">
    <form action="/search/" method="GET">
        <input type="text" class="form-control" name="q" autocomplete="off" placeholder="Поиск" value="<?=$_REQUEST['q'];?>">
        <button type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>