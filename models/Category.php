<?php 

class Category {

    private $id;
	private $name;
	private $db;

	public function __construct() 
	{
		$this->db = new DB();
	}

    public function setId($id) {

        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getAllCategories() {
        $sql = 'SELECT * FROM categorias';
        $statement = $this->db->prepare($sql);
        
        $result = false;

        if ($statement->execute()) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
        }

        return $result;
    }

    public function save() {
        $sql = 'INSERT INTO categorias (nombre) VALUES (:nombre)';
        $params = array(':nombre' => $this->getName());
        $result = false;
        $statement = $this->db->prepare($sql);
        if ($statement->execute($params)) {
           $result = true;
        }
        return $result;
    }

    public function update($id, $name) {
       
        
        $sql = 'UPDATE categorias SET nombre = :nombre WHERE id = :id';
        
        $params = array(
            ':nombre' => $name,
            ':id' => $id 
        );
        
        $statement = $this->db->prepare($sql);
        
        return $statement->execute($params);
    }

    public function getOneById($id) {
        $sql = 'SELECT * FROM categorias WHERE id = :id';
        $params = array(':id' => $id);

        $statement = $this->db->prepare($sql);
        
        $result = false;

        if ($statement->execute($params)) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ)[0];
        }

        return $result;
    }

    public function delete($id) {
        $sql = 'DELETE FROM categorias WHERE id = :id';
        $params = array(':id' => $id);
        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        
    }

}