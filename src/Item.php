<?php

class Item
{
    private $id;
    private $name;
    private $description;
    private $category;
    private $price;
    private $stock;

    public function __construct($name, $description, $category, $price, $stock, $id = -1)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function saveToDb(mysqli $conn) {
        if ($this->id == -1){
            $query = "INSERT INTO `items` (`id`, `name`, `description`, `category`, `price`, `stock`)"
                      . "VALUES ({$this->id}, {$this->name}, {$this->description}, {$this->category}, {$this->price}, {$this->stock})";
            if (!$conn->query($query)) {
                echo "Błąd zapisu przedmiotu do bazy danych" . $conn->error;
            }
        }
    }
}

