<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../entities/film.php';
include_once '../config/db.php';

$db=new Db();
$pdo=$db->getPdo();
$film=new Film($pdo);
$searchParams=isset($_GET["sp"])?$_GET["sp"]:"";
$stmt=$film->search($searchParams);
$count=$stmt->rowCount();

if($count>0){
    $filmsArr=array();
    $filmsArr["regs"]=array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $filmUnit=array("numberOfWeek"=>$numberOfWeek,"title"=>$title,"genre"=>$genre);
        array_push($filmsArr["regs"],$filmUnit);
    }
    http_response_code(200);
    echo json_encode($filmsArr);
}
else{
    http_response_code(404);
    echo json_encode(array("message"=>"No films found."));
}
?>