<?php

class Utils {
    public static function deleteSession($name) {
        
        if (isset($_SESSION[$name])) {
            
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;
    }

    public static function isLogged() {
        if (!isset($_SESSION['identity'])) {
            header('Location:' . base_url . '/User/signIn');
        }
    }

    public static function getAll($table) {
        
        
        $db = new DB();
        $params = array(':table' => $table);
        $result = false;

        $statement = $db->prepare('SELECT * FROM ' . $table);
        


        if ($statement->execute()) {

            $result = $statement->fetchAll(PDO::FETCH_OBJ);

        }
        
        return $result;
    }

}