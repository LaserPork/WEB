<?php
if(isset($_SESSION['opravneni'])){
    if($_SESSION['opravneni']==0) {
        $template_params['menu'] = phpWrapperFromFile("view/adminnav.html");
    }else if($_SESSION['opravneni']==1) {
        $template_params['menu'] = phpWrapperFromFile("view/recnav.html");
    }else if($_SESSION['opravneni']==2) {
        $template_params['menu'] = phpWrapperFromFile("view/usernav.html");
    }
    }else{
    $template_params['menu']=phpWrapperFromFile("view/unloggednav.html");
}