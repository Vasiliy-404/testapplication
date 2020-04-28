<?
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
define('PATH', $_SERVER['DOCUMENT_ROOT']);
define('SALT', 's9gHkd30dg8f');
require_once 'core/functions.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';
require_once 'db.php';
require_once 'modules/Database.php';
require_once 'modules/Ajax/AjaxFactory.php';
AjaxFactory::ajax();
Route::start();
?>