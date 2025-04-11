<?php
/**
 * searchform
 *
 * @package Bedstone
 */
?>
<div class="main-search hidden-print">
    <form class="main-search__form" role="search" method="get" action="<?php echo home_url('/'); ?>">
        <input class="main-search__field" type="text" name="s" placeholder="Search" title="Search" value="<?php echo get_search_query() ?>">
        <button class="main-search__btn" type="submit" title="Submit Search"><i class="fa fa-search"></i></button>
    </form>
</div>
