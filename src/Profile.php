<?php

class Profile
{
    private string $name;
    public string $info;
    public array $skills;
    public array $services;

    public function __construct(string $name, string $info, array $skills, array  $services)
    {
        $name = trim($name);
        if ($name === "") {
            throw new Exception("Ism bo'sh bo'lishi mumkin emas");
        }

        $this->name = $name;


        $this->info = $info;
        $this->skills = $skills;
        $this->services = $services;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $chName): void
    {
        $chName = trim($chName);
        if($chName === "") {
            throw new Exception("Ism bo'sh bo'lishi mukin emas");
        }
        $this->name = $chName;
    }
}
