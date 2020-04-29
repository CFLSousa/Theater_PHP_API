<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../entities/film.php';
include_once '../config/db.php';

$db=new Db();
$pdo=$db->getPdo();
$film=new Film($pdo);
$stmt=$film->readAll();
$count=$stmt->rowCount();

if($count>0){
    $films=array();
    $films["body"]=array();
    $films["count"]=$count;

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $f=array("id"=>$id,"title"=>$title,"genre_id"=>$genre_id);
        array_push($films["body"],$f);
    }
    http_response_code(200);
    echo json_encode($films);
}
else{
    http_response_code(404);
    echo json_encode(array("body"=>array(),"count"=>0,"message"=>"No films found."));
}
?>