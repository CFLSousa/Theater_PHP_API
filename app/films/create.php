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

if(!empty($data->id)&&!empty($data->title)&&!empty($data->genre_id)){
    $film->id=$data->id;
    $film->title=$data->title;
    $film->genre_id=$data->genre_id;
  
    if($film->create()){
        http_response_code(201);
        echo json_encode(array("message"=>"Film was created."));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message"=>"Unable to create film."));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Unable to create film. Data is incomplete."));
}
?>