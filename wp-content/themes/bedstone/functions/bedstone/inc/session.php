<?php
/**
 * session functions
 *
 * @package Bedstone
 */

/**
 * [optional] session support
 */
//add_action('init', 'session_initialize');
function session_initialize()
{
    if (!session_id()) {
        session_start();
    }
}
