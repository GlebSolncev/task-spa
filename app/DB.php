<?php

class DB extends PDO{

    const PARAM_host='localhost';
    const PARAM_port='3306';
    const PARAM_db_name='packreg_db';
    const PARAM_user='root';
    const PARAM_db_pass='';

    public $version = '0.1';

    public function __construct($options=null){
        parent::__construct('mysql:host='.DB::PARAM_host.';port='.DB::PARAM_port.';dbname='.DB::PARAM_db_name,
            DB::PARAM_user,
            DB::PARAM_db_pass,$options);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    public function query($query){ //secured query with prepare and execute
        $args = func_get_args();
        array_shift($args); //first element is not an argument but the query itself, should removed

        $reponse = parent::prepare($query);
        $reponse->execute($args);
        return $reponse;

    }

    public function insert_with_return_id($query)
    {
        $stmt = parent::prepare($query);
        $stmt->execute();
        $id = parent::lastInsertId();
        return $id;
    }
    public function update($query)
    {
        $stmt = parent::prepare($query);
        $stmt->execute();
        return 1;
    }

    public function insecureQuery($query){ //you can use the old query at your risk ;) and should use secure quote() function with it
        return parent::query($query);
    }

    public function select($text){
        $ret = $this->query($text);
        $fetch = $ret->fetchAll();
        return $fetch;
    }

    public function insert($text)
    {
        $statement = $this->insecureQuery($text);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);


        dd($statement->lastInsertId());
        if($result["id"]){
            return $result["id"];
        }

        return false;
    }


}