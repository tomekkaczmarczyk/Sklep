<?php

class Message
{
    private $id;
    private $user_id;
    private $admin_id;
    private $text;
    private $date;

    public function __construct($id = -1, $user_id = -1, $admin_id = -1, $text = "", $date = "")
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->admin_id = $admin_id;
        $this->text = $text;
        $this->date = $date;
    }


    public function getId()
    {
        return $this->id;
    }


    public function getUserId()
    {
        return $this->user_id;
    }


    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


    public function getAdminId()
    {
        return $this->admin_id;
    }


    public function setAdminId($admin_id)
    {
        $this->admin_id = $admin_id;
    }


    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function saveMsg(mysqli $conn)
    {
        if (-1 === $this->id) {
            $query = "INSERT INTO messages (user_id, admin_id, text, date,)"
                . "VALUES ('{$this->user_id}', '{$this->admin_id}', '{$this->text}', "
                . "'{$this->date}')";
            $result = $conn->query($query);
            if(true == $result) {
                $this->id = $conn->insert_id;
                return true;
                echo "Wiadomość wysłano";
            } else {
                return false;
                echo "Nie udało się wysłać wiadomości";
            }
        }
    }




}