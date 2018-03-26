<?php

class DB{
    private $dbh;
    private $stmt;

    public function __construct(){
        try{
            $this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        } catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function query($query){
		$this->stmt = $this->dbh->prepare($query);
	}
	public function bind($param, $value, $type = null){
		if(is_null($type)){
			switch(true){
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
					default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}
	public function execute(){
		return $this->stmt->execute();
	}
	public function resultSet(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function singleResult(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
}

/*
$db->query('SELECT * FROM mensagem');
$rows = $db->resultSet();

echo "TESTE BANCO<br /><br />";

foreach ($rows as $value) {
    echo "
        ID: ".$value['id']."<br />
        Título: ".$value['titulo']."<br />
        Mensagem: ".$value['mensagem']."<br />
        Nível: ".$value['nivel']."<br />
        Data de Criação: ".$value['dataCriacao']."<br />
        <br />
    ";
}
*/