<?php
require_once 'model/twig/lib/Twig/Autoloader.php';
require 'controller/functions.php';
include('controller/db_settings.inc.php');
include('model/db_pdo.class.php');
include('model/user.class.php');

$user = new user();
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);
$template = $twig->loadTemplate('view.html');
$template_params = array();
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET['logout'])) {
    unset($_SESSION['nick']);
    unset($_SESSION['opravneni']);
    unset($_SESSION['id']);
}

include('controller/menu.php');
include('controller/register.php');
if(isset($_GET['page'])) {
    $stranka = $_GET['page'];
}else{
    $stranka = "okonferenci";
}
if(isset($_POST['textareaprispevek'])){
    include('controller/postpost.php');
}
if(isset($_POST['radios'])){
    $stranka = "mojerecenze";
   $user->vote($_POST['ohodnotit'],$_POST['radios']);
}
if(isset($_POST['prirad'])){
    $user->prirad($_POST['prirad'],$_POST['koho']);
}
if(isset($_POST['smazat'])){
    $user->delete($_POST['smazat']);
}


if($stranka == "konani" ||
    $stranka == "kontakty" ||
    $stranka == "login" ||
    $stranka == "okonferenci" ||
    $stranka == "register" ||
    $stranka == "sponzori" ||
    $stranka == "temata" ||
    $stranka == "terminy")
{
    $template_params["obsah"] = phpWrapperFromFile("view/" . $stranka . ".html");
}

if(isset($_SESSION['opravneni'])){
    if($stranka == "novyprispevek") {
        $template_params["obsah"] = phpWrapperFromFile("view/" . $stranka . ".html");
    }else if($stranka == "mojeprispevky") {
        $template_params["obsah"] = makeTable($user->fetchMyPosts($_SESSION["nick"]));
    }
    if($_SESSION['opravneni']<2) {
        if ($stranka == "mojerecenze") {
            $template_params["obsah"] = makeReviewsTable($user->fetchMyReviews($_SESSION['nick']));
        } else if (isset($_GET['clanek'])) {
            $template_params["obsah"] = showPostWithOptions($user->fetchPostByReviewId($_GET['clanek']));
        }
    }
    if($_SESSION['opravneni']==0){
        if($stranka == "prispevky" ) {
            $template_params["obsah"] = showAllPosts($user->fetchAllPosts());
        }
        else if($stranka == "recenze" ){
            $template_params["obsah"] = showAllPostsWithOptions($user->fetchAllReviews(),$user->fetchAllReviewers());
        }
    }
}


if($stranka!="login" && $stranka!="register"){
    echo $template->render($template_params);
}else if($stranka == 'login'){
    $template = $twig->loadTemplate('login.html');
    if(isset($_POST['nick'])) {
        if ($user->login($_POST['nick'],$_POST['password'])) {
            $_SESSION['opravneni'] = $user->rows['opravneni'];
            $_SESSION['nick'] = $user->rows["nick"];
            $_SESSION['id'] = $user->rows['id'];
            $template_params["obsah"] = phpWrapperFromFile("view/okonferenci.html");
            $template = $twig->loadTemplate('view.html');
        } else {
            include('controller/loginfail.php');
        }
    }

    include('controller/menu.php');
    echo $template->render($template_params);
}else if($stranka == 'register'){
    $template = $twig->loadTemplate('register.html');
    echo $template->render($template_params);
}

if(!isset($template_params["obsah"])){
    echo "Pristup odepren";
}

?>