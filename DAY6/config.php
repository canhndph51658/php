<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('CART_FILE')) {
    define('CART_FILE', 'data.json');
}
