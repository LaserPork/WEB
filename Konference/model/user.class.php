<?php

class user extends db_pdo{

    function __construct(){
        $this->Connect();
    }

    public $rows;

    function login($username, $password){
        $array = array();
        $array[] = array(
            "column" => "nick",
            "value" => $username,
            "symbol" => "="
            );
        $array[] = array(
            "column" => "heslo",
            "value" => $password,
            "symbol" => "="
        );

        $this->rows = $this->DBSelectOne('users','*',$array);
        return $this->rows;
    }

    function fetchMyPosts($username){
        $array = array();
        $array[] = array(
            "column" => "nick",
            "value" => $username,
            "symbol" => "="
        );
        $user = $this->DBSelectOne('users','*',$array);
        if($user!=false){
            $array = array();
            $array[] = array(
                "column" => "uzivatel",
                "value" => $user['id'],
                "symbol" => "="
            );
            return $this->DBSelectAll('prispevky','*',$array);
        }
    }

    function delete($postId){
        $array = array();
        $array[] = array(
            "column" => "id",
            "value" => $postId,
            "symbol" => "="
        );
        $this->DBDelete('prispevky',$array);
        $array = array();
        $array[] = array(
            "column" => "prispevek",
            "value" => $postId,
            "symbol" => "="
        );
        $this->DBDelete('recenze',$array);
    }

    function fetchAllReviewers(){
        $array = array();
        $array[] = array(
            "column" => "opravneni",
            "value" => 1,
            "symbol" => "="
        );
        return $this->DBSelectAll('users','*',$array);
    }

    function prirad($kam,$koho){
        $array = array();
        $array[] = array(
            "column" => "id",
            "value" => $kam,
            "symbol" => "="
        );
        $row = $this->DBSelectOne('recenze','*',$array);

        $userid = array();
        $userid[] = array(
            "column" => "nick",
            "value" => $koho,
            "symbol" => "="
        );
        $row2 = $this->DBSelectOne('users','*',$userid);

        $row['recenzent'] = $row2['id'];

        $this->DBUpdate('recenze',$row,$array);

    }

    function fetchAllPosts(){

            $array = array();
            $array[] = array(
                "column" => "nick",
                "value" => 0,
                "symbol" => "!="
            );
            return $this->DBSelectAll('pohled_prispevky','*',$array);
    }

    function fetchAllReviews(){
        $array = array();
        $array[] = array(
            "column" => "id",
            "value" => -1,
            "symbol" => ">"
        );
        return $this->DBSelectAll('pohled_recenze','*',$array);
    }

    function fetchMyReviews($username){

            $array = array();
            $array[] = array(
                "column" => "recenzent",
                "value" => $username,
                "symbol" => "="
            );
            return $this->DBSelectAll('pohled_recenze','*',$array);
    }

    function fetchPostByReviewId($id){
        $array = array();
        $array[] = array(
            "column" => "id",
            "value" => $id,
            "symbol" => "="
        );

        $row = $this->DBSelectOne('recenze','*',$array);


        $array = array();
        $array[] = array(
            "column" => "id",
            "value" =>  $row['prispevek'],
            "symbol" => "="
        );
        return $this->DBSelectOne('prispevky','*',$array);
    }

    function register($username,$password){
        $array = array();
        $array[] = array(
            "column" => "nick",
            "value" => $username,
            "symbol" => "="
        );
        $array[] = array(
            "column" => "heslo",
            "value" => $password,
            "symbol" => "="
        );

        if($this->DBSelectOne('users','*',$array)==false) {
            $item = array(
                "opravneni" => 2,
                "nick" => $username,
                "heslo" => "$password"
            );
            $this->DBInsert('users', $item);
        }else{
            echo "User already exists";
        }
    }

    function vote($co,$jak){
        if(isset ($_GET['clanek'])){
        $array = array();
        $array[] = array(
            "column" => "prispevek",
            "value" => $co,
            "symbol" => "="
        );
            $array[] = array(
                "column" => "id",
                "value" => $_GET['clanek'],
                "symbol" => "="
            );
        $row = $this->DBSelectOne('recenze','*',$array);
        $row['hodnoceni'] = $jak;
       $this->DBUpdate('recenze',$row,$array);
       }
    }

}