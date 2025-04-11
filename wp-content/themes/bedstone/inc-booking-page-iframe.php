<?php

// iframe for booking
$iframe_src = 'https://webstore.tdstickets.com/step1/4314';
if (defined('ENV_PAGE_TDS_TEST_BOOK') && ENV_PAGE_TDS_TEST_BOOK == get_the_ID()) {
    // TDS tests per Ron
    $iframe_src = 'https://node.stage.tdstickets.com/step1/4314';
}
?>

<div class="iframe-wrapper">
<iframe title="Jefferson Lines search form iframe" src="https://ride.jeffersonlines.com/#/searchformiframe" width="100%" height="550px"></iframe>
</div>
