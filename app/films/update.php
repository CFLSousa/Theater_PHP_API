<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
include_once '../entities/film.php';
include_once '../config/db.php';

$db=new Db();
$pdo=$db->getPdo();
$film=new Film($pdo);
$data=json_decode(file_get_contents("php://input"));
$film->id=$data->id;
$film->title=$data->title;
$film->genre_id=$data->genre_id;

if($film->update()){
    http_response_code(200);
    echo json_encode(array("message"=>"Film was updated."));
}
else{
    http_response_code(503);
    echo json_encode(array("message"=>"Unable to update film."));
}
?>