<?php
function get_unique_from_array($list)
{
    // Extract 'productID' values using array_column
$productIDs = array_column($list, 'productID');

// Get unique 'productID' values
$uniqueProductIDs = array_unique($productIDs);

// Convert the result to indexed array
$uniqueProductIDs = array_values($uniqueProductIDs);

   return $uniqueProductIDs;

}
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
