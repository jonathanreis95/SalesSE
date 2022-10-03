<?php

namespace Core;

use PDO;

abstract Class BaseModel
{
    private $pdo;
    protected $table;
    protected $id;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function executeSQL($query)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;        
    }

    public function findAll()
    {
        $query = "SELECT * FROM  {$this->table} tb where tb.status='1'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;        
    }

    public function find($id)
    {
        $query = "SELECT * FROM {$this->table} tb WHERE tb.{$this->id} = :id and tb.status='1'";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;        
    }

    public function save(array $data, $table = null, $lastId = false)
    {  

        if(!$table){
            $table = $this->table;
        }
 
        $newData = $this->prepareDataInsert($data);
        
        $query = "INSERT INTO {$table} ({$newData[0]}) VALUES ($newData[1]) ";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($newData[2]); $i++){
            $stmt->bindValue("{$newData[2][$i]}", $newData[3][$i]);
        }
        $result = $stmt->execute();
        $return = null;
        if($lastId){
            $return = $this->pdo->lastInsertId();
        }else{
            $return = $result;
        }
       
        $stmt->closeCursor();
        return $return; 
    }

    /**
     * Function that will prepare bynds and values ​​for Insert
     */
    private function prepareDataInsert(array $data)
    {
        $strKeys = '';
        $strBinds = '';
        $binds = [];
        $values = [];

        foreach($data as $key => $value){
            $strKeys = "{$strKeys},{$key}";
            $strBinds = "{$strBinds},:{$key}";
            $binds[] = ":{$key}";
            $values[] = $value;
        }
        $strKeys = substr($strKeys, 1);
        $strBinds = substr($strBinds, 1);

        return [
            $strKeys,
            $strBinds,
            $binds,
            $values
        ];
    }

    public function update(array $data, $id)
    {        
        $newData = $this->prepareDataUpdate($data);
      
        $query = "UPDATE {$this->table} SET {$newData[0]} WHERE {$this->id}=:id ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id', $id);
        for($i = 0; $i < count($newData[1]); $i++){
            $stmt->bindValue("{$newData[1][$i]}", $newData[2][$i]);
        }
        
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;   
    }

    /**
     * Function that will prepare bynds and values ​​for Update
     */
    private function prepareDataUpdate(array $data)
    {
        $strKeysBinds  = '';
        $binds = [];
        $values = [];

        foreach($data as $key => $value){
            $strKeysBinds = "{$strKeysBinds}, {$key}=:{$key}";            
            $binds[] = ":{$key}";
            $values[] = $value;
        }
        $strKeysBinds = substr($strKeysBinds, 1);
        return [
            $strKeysBinds,
            $binds,
            $values
        ];
    }

}