<?php 


class Provider {
    private $id;
	private $name;
    private $lastName;
    private $socialReason;
    private $addres;
    private $phone;
    private $comment;
	private $db;

	public function __construct() 
	{
		$this->db = new Connection();
	}

    public function setId($id) {

        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSocialReason($socialReason) {
        $this->socialReason = $socialReason;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setAddres($addres) {
        $this->addres = $addres;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getAllProviders() {
        $sql = 'SELECT * FROM proveedores';
        $statement = $this->db->prepare($sql);
        
        $result = false;

        if ($statement->execute()) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
        }

        return $result;
    }

    public function save() {
        $sql = 'INSERT INTO proveedores (nombre, apellidos, razon_social, domicilio, telefono, observaciones)';
        
        $sql .= ' VALUES (:nombre, :apellidos, :razon_social, :domicilio, :telefono, :observaciones)';
        
        $params = array(
            ':nombre' => $this->getName(),
            ':apellidos' => $this->lastName,
            ':razon_social' => $this->socialReason,
            ':domicilio' => $this->addres,
            ':telefono' => $this->phone,
            ':observaciones' => $this->comment
        );

        $result = false;
        
        $statement = $this->db->prepare($sql);
        
        if ($statement->execute($params)) {
           $result = true;
        }
        
        return $result;
    }

    public function update($id, $name, $lastName, $socialReason, $addres, $phone, $comment) {
       
        
        $sql = 'UPDATE proveedores SET nombre = :nombre , apellidos = :apellidos, razon_social = :razon_social, domicilio = :domicilio, telefono = :telefono, observaciones = :observaciones WHERE id = :id';

        $params = array(
            ':nombre' => $name,
            ':apellidos' => $lastName,
            ':razon_social' => $socialReason,
            ':domicilio' => $addres,
            ':telefono' => $phone,
            ':observaciones' => $comment,
            ':id' => $id 
        );


        $statement = $this->db->prepare($sql);
        
        return $statement->execute($params);
    }

    public function getOneById($id) {
        $sql = 'SELECT * FROM proveedores WHERE id = :id';
        $params = array(':id' => $id);

        $statement = $this->db->prepare($sql);
        
        $result = false;

        if ($statement->execute($params)) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ)[0];
        }

        return $result;
    }

    public function delete($id) {
        $sql = 'DELETE FROM proveedores WHERE id = :id';
        $params = array(':id' => $id);
        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        
    }
}