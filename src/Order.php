<?php

class Order implements JsonSerializable
{
    private $user_id;
    private $status;
    private $sum;
    private $date;
    private $id;

    public function __construct($user_id, $status, $sum, $date, $id=-1)
    {

        $this->user_id = $user_id;
        $this->status = $status;
        $this->sum = $sum;
        $this->date = $date;
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function saveToDb(mysqli $conn)
    {
        if ($this->id == -1){
            $query = "INSERT INTO `orders` (`id`, `user_id`, `status`, `sum`, `date`)"
                . "VALUES ({$this->id}, {$this->user_id}, {$this->status}, {$this->sum}, {$this->date})";
            $result = $conn->query($query);
            if (!$result) {
                echo "Błąd zapisu zamówienia do bazy danych." . $conn->error;
            }
        } else {
            $query = "UPDATE `orders` SET "
                . "`user_id`={$this->user_id},"
                . "`status`={$this->status},"
                . "`sum`={$this->sum},"
                . "`date`={$this->date},"
                . "WHERE id={$this->id}";
        }
    }

    public static function delOrder(mysqli $conn, $id) {
        $query = "DELETE FROM items WHERE id='{$id}'";
        $result = $conn->query($query);

        if (!$result) {
            echo "Błąd - nie skasowano zamówienia" . $conn->error;
        }
    }

    public static function getAllByUser($conn, $user_id) {
        $query = "SELECT * FROM orders WHERE user_id='{$user_id}'";
        $result = $conn->query($query);

        if (!$result) {
            echo "Błąd - nie pobrano zamówień z bazy danych" . $conn->error;
            return false;
        } else {
            if ($result->num_rows > 0) {
                $orders = [];
                while($row = $result->fetch_assoc()) {
                    $orderObj = new Order(
                        $row['user_id'],
                        $row['status'],
                        $row['sum'],
                        $row['date'],
                        $row['id']
                    );
                    $orders[] = $orderObj;
                }
                return $orders;
            }
        }
    }

    public function jsonSerialize()
    {
        return [$this->user_id,
            $this->status,
            $this->sum,
            $this->date,
            $this->id];
    }
}