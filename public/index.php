<?php

require_once "../app/models/Model.php";
require_once "../app/models/User.php";
require_once "../app/controllers/UserController.php";
require_once "../app/models.Post.php";
require_once "../app/controllers/PostController.php";

//set our env variables
$env = parse_ini_file('../.env');
define('DBNAME', $env['DBNAME']);
define('DBHOST', $env['DBHOST']);
define('DBUSER', $env['DBUSER']);
define('DBPASS', $env['DBPASS']);

use app\controllers\UserController;

use app\controllers\PostController;

//get uri without query strings
$uri = strtok($_SERVER["REQUEST_URI"], '?');

//get uri pieces
$uriArray = explode("/", $uri);
//0 = ""
//1 = users
//2 = 1

if ($uriArray[1] === 'api' && $uriArray[2] === 'users') 
{ 
    $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;

    $userController = new UserController();

    switch ($_SERVER['REQUEST_METHOD']) 
    {
        case 'GET':
            $id ? $userController->getUserByID($id) : $userController->getAllUsers();
            break;
        case 'POST':
            $userController->saveUser();
            break;
        case 'PUT':
            $userController->updateUser($id);
            break;
        case 'DELETE':
            $userController->deleteUser($id);
            break;
    }
}

if ($uriArray[1] === 'api' && $uriArray[2] === 'posts') 
{
    $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;

    $postController = new PostController();

    switch ($_SERVER['REQUEST_METHOD']) 
    {
        case 'GET':
            $id ? $postController->getPostByID($id) : $postController->getAllPosts();
            break;
        case 'POST':
            $postController->savePost();
            break;
        case 'PUT':
            $postController->updatePost($id);
            break;
        case 'DELETE':
            $postController->deletePost($id);
            break;
    }
}

if ($uri === '/users-add' && $_SERVER['REQUEST_METHOD'] === 'GET')
{
    $userController = new UserController();
    $userController->usersAddView();
} 

if ($uri === '/users-update' && $_SERVER['REQUEST_METHOD'] === 'GET')
{
    $userController = new UserController();
    $userController->usersUpdateView();
} 

if ($uri === '/users-delete' && $_SERVER['REQUEST_METHOD'] === 'GET')
{
    $userController = new UserController();
    $userController->usersDeleteView();
} 

if ($uri === '/users-view' && $_SERVER['REQUEST_METHOD'] === 'GET')
{
    $userController = new UserController();
    $userController->usersView();
}

if ($uri === '/posts-add' && $_SERVER['REQUEST_METHOD'] === 'GET')
{
    $postController = new PostController();
    $postController->postsAddView();
} 

if ($uri === '/posts-update' && $_SERVER['REQUEST_METHOD'] === 'GET')
{
    $postController = new PostController();
    $postController->postsUpdateView();
} 

if ($uri === '/posts-delete' && $_SERVER['REQUEST_METHOD'] === 'GET')
{
    $postController = new PostController();
    $postController->postsDeleteView();
} 

if ($uri === '/posts-view' && $_SERVER['REQUEST_METHOD'] === 'GET')
{
    $postController = new PostController();
    $postController->postsView();
}

include '../public/assets/views/notFound.html';
exit();
?>
