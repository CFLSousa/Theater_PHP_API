<?php
class Film{
    private $pdo;
    private $table="film";
    public $id;
    public $title;
    public $genre_id;

    public function __construct($db){
        $this->pdo=$db;
    }

    function create(){
        $query="insert into ".$this->table." set id=:id,title=:title,genre_id=:genre_id";
        $stmt=$this->pdo->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->genre_id=htmlspecialchars(strip_tags($this->genre_id));
        $stmt->bindParam(":id",$this->id);
        $stmt->bindParam(":title",$this->title);
        $stmt->bindParam(":genre_id",$this->genre_id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function readAll(){
        $query="select id,title,genre_id from ".$this->table." order by id asc";
        $stmt=$this->pdo->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function update(){
        $query="update ".$this->table." set title=:title,genre_id=:genre_id where id=:id";
        $stmt=$this->pdo->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->genre_id=htmlspecialchars(strip_tags($this->genre_id));
        $stmt->bindParam(':id',$this->id);
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':genre_id',$this->genre_id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function delete(){
        $query="delete from ".$this->table." where id=:id";
        $stmt=$this->pdo->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id',$this->id);
    
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function search($searchParams){
        $query="select w.numberOfWeek,f.title,g.genre from ".$this->table." f ".
            "left join genre g on f.genre_id=g.id ".
            "left join schedule s on f.id=s.film_id ".
            "left join week w on s.week_id=w.id ".
            "where f.title like ? or g.genre like ? ".
            "order by w.numberOfWeek asc";
        $stmt=$this->pdo->prepare($query);
        $searchParams=htmlspecialchars(strip_tags($searchParams));
        $searchParams="%{$searchParams}%";
        $stmt->bindParam(1,$searchParams);
        $stmt->bindParam(2,$searchParams);
        $stmt->execute();
        return $stmt;
    }

    function searchByWeek($weekNum){
        $query="select f.title,g.genre from ".$this->table." f ".
            "left join genre g on f.genre_id=g.id ".
            "left join schedule s on f.id=s.film_id ".
            "left join week w on s.week_id=w.id ".
            "where w.numberOfWeek=?";
        $stmt=$this->pdo->prepare($query);
        $searchParams=htmlspecialchars(strip_tags($weekNum));
        $stmt->bindParam(1,$searchParams);
        $stmt->execute();
        return $stmt;
    }
}
?>