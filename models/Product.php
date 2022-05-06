<?php 

class Product {
    

    private $category_id;
    private $date;
	private $db;
    private $description;
    private $id;
    private $img;
	private $name;
    private $price;
    private $provider_id;
    private $stock;

	public function __construct() 
	{
		$this->db = new DB();
	}

    public function setId($id) {

        $this->id = $id;
    }

    public function setProviderId($id) {

        $this->provider_id = $id;
    }

    public function setImg($img) {
        $this->img = $img;
    }

    public function setCategoryId($id) {

        $this->category_id = $id;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function getImg() {
        return $this->img;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getAllProducts() {
        $sql = "select productos.*, categorias.nombre as 'categoria', proveedores.nombre as 'proveedor' from productos join categorias on productos.categoria_id = categorias.id join proveedores on proveedores.id = productos.proveedor_id";
        $statement = $this->db->prepare($sql);
        
        $result = false;

        if ($statement->execute()) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
        }

        return $result;
    }

    public function save() {
        $sql = 'INSERT INTO productos (nombre, descripcion, precio, imagen, categoria_id, proveedor_id, stock, fecha) '; 
        $sql .= 'VALUES (:nombre, :descripcion, :precio, :imagen, :categoria_id, :proveedor_id, :stock, CURDATE())';
         
        $params = array(
            ':nombre' => $this->name,
            ':descripcion' => $this->description,
            ':precio' => $this->price,
            ':imagen' => $this->img,
            ':categoria_id' => $this->category_id,
            ':proveedor_id' => $this->provider_id,
            ':stock' => $this->stock
        );

        $statement = $this->db->prepare($sql);


        return $statement->execute($params);
        
    }

    public function update($id) {
       
        
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio ";
        
        $params = array(
            ':nombre' => $this->name,
            ':descripcion' => $this->description,
            ':precio' => $this->price,
            ':categoria_id' => $this->category_id,
            ':proveedor_id' => $this->provider_id,
            ':stock' => $this->stock,
            ':id' => $id
        );
        
        if (!empty($this->img)) {
            $sql .= ",imagen = :imagen";
            $params += [":img" => $this->img];
        }
        
        $sql .= ", categoria_id = :categoria_id, proveedor_id = :proveedor_id, stock = :stock, fecha = CURDATE()  WHERE id = :id";
        $statement = $this->db->prepare($sql);
        return $statement->execute($params);
        // return $params;
    }

    public function getOneById($id) {
        $sql = "select productos.*, categorias.nombre as 'categoria', proveedores.nombre as 'proveedor' from productos join categorias on productos.categoria_id = categorias.id join proveedores on proveedores.id = productos.proveedor_id WHERE productos.id = $id";
        $params = array(':id' => $id);

        $statement = $this->db->prepare($sql);
        
        $result = false;

        if ($statement->execute($params)) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ)[0];
        }

        return $result;
    }

    public function delete($id) {
        $sql = 'DELETE FROM productos WHERE id = :id';
        $params = array(':id' => $id);
        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        
    }


}