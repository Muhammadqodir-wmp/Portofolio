<?php
 
 class Database{
    public string $dsn, $username, $password;
    private PDO $connection;

    public function __construct(string $dsn)
    {
        $this->dsn = $dsn;
        $this->username = "omborchi";
        $this->password = '5R<QG"28|S{u';
        
        $this->connection = new PDO($this->dsn,$this->username, $this->password );
    }

    public function getCon():PDO
    {
            return $this->connection;
    }

 }

