<?php
if(isset($_POST['textinputreg'])){
    if($_POST['passwordinputreg']==$_POST['passwordinput2reg']) {
        $user->register($_POST['textinputreg'], $_POST['passwordinputreg']);
        $_GET['page'] = 'okonferenci';
    }else{
        $stranka = 'register';
    }
}