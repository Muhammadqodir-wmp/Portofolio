<?php



class Project
{
    private int $id;
    private string $title;
    private string $description;

    public function __construct()
    {
       
 

    }

    public function getId():int{
        return $this->id;
    }
    public function getTitle():string{
        return $this->title;
    }
    public function getDescription(): string{
        return $this->description;
    }
  
}
