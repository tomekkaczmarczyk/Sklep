<?php

class Item implements JsonSerializable
{
    private $name;
    private $description;
    private $category;
    private $price;
    private $stock;
    private $id;

    public function __construct($name, $description, $category, $price, $stock, $id = -1)
    {
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function saveToDb(mysqli $conn) {
        if ($this->id == -1){
            $query = "INSERT INTO `items` (`id`, `name`, `description`, `category`, `price`, `stock`)"
                      . "VALUES ({$this->id}, {$this->name}, {$this->description}, {$this->category}, {$this->price}, {$this->stock})";
            $result = $conn->query($query);
            if (!$result) {
                echo "Błąd zapisu przedmiotu do bazy danych" . $conn->error;
            }
        } else {
            $query = "UPDATE `items` SET "
            . "`name`={$this->name},"
            . "`description`={$this->description},"
            . "`category`={$this->category},"
            . "`price`={$this->price},"
            . "`stock`={$this->stock}"
            . "WHERE id={$this->id}";
        }
    }

    public static function delItem(mysqli $conn, $id) {
        $query = "DELETE FROM items WHERE id='{$id}'";
        $result = $conn->query($query);

        if (!$result) {
            echo "Błąd - nie skasowano przedmiotu" . $conn->error;
        }
    }

    public static function getAllByCategory($conn, $category) {
        $query = "SELECT * FROM items WHERE category='{$category}'";
        $result = $conn->query($query);

        if (!$result) {
            echo "Błąd - nie pobrano przedmiotów z bazy danych" . $conn->error;
            return false;
        } else {
            if ($result->num_rows > 0) {
                $items = [];
                while($row = $result->fetch_assoc()) {
                    $itemObj = new Item(
                        $row['name'],
                        $row['description'],
                        $row['category'],
                        $row['price'],
                        $row['stock'],
                        $row['id']
                    );
                    $items[] = $itemObj;
                }
                return $items;
            }
        }
    }

    public static function getAllCategories($conn) {
        $query = "SELECT * FROM items";
        $result = $conn->query($query);

        $categories = [];
        while($row = $result->fetch_assoc()) {
            if (!(in_array($row['category'], $categories))) {
                $categories[] = $row['category'];
            }
        }
        return $categories;
    }


    function jsonSerialize()
    {
        return [$this->name,
            $this->description,
            $this->category,
            $this->price,
            $this->stock,
            $this->id];
    }
}

