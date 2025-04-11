<?php
/**
 * dev helpers
 *
 * @package Bedstone
 */

/**
 * Debug helper -- print_r()
 *
 * @param mixed $var To be debugged
 * @param bool $exit Triggers php exit
 *
 * @return void
 */
function debug($var, $exit = false)
{
    $backtrace = debug_backtrace();
    echo '<pre class="debug">';
    echo (isset($backtrace[0]['file'])) ? 'Backtrace File: ' . $backtrace[0]['file'] . "\n" : '';
    echo (isset($backtrace[0]['line'])) ? 'Backtrace Line: ' . $backtrace[0]['line'] . "\n" : '';
    print_r($var);
    echo '</pre>';
    if ($exit) {
        exit;
    }
}

/**
 * Dump helper -- var_dump()
 *
 * @param mixed $var To be dumped
 * @param bool $exit Triggers php exit
 *
 * @return void
 */
function dump($var, $exit = false)
{
    $backtrace = debug_backtrace();
    echo '<pre class="debug">';
    echo (isset($backtrace[0]['file'])) ? 'Backtrace File: ' . $backtrace[0]['file'] . "\n" : '';
    echo (isset($backtrace[0]['line'])) ? 'Backtrace Line: ' . $backtrace[0]['line'] . "\n" : '';
    var_dump($var);
    echo '</pre>';
    if ($exit) {
        exit;
    }
}
