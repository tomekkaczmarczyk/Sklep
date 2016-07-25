<?php

class User
{

    private $id;
    private $name;
    private $surname;
    private $mail;
    private $hashedpassword;
    private $address;
    private $is_admin;


    public function __construct($id = -1, $name = "", $surname = "", $mail = "", $hashedpassword = "", $address = "", $is_admin = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->mail = $mail;
        $this->hashedpassword = $hashedpassword;
        $this->address = $address;
        $this->is_admin = $is_admin;
    }


    public function getId()
    {
        return $this->id;
    }


    public function getMail()
    {
        return $this->mail;
    }


    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getHashedPassword()
    {
        return $this->hashedpassword;
    }

    public function setPassword($hashedpassword)
    {
        $this->hashedPassword = password_hash($hashedpassword, PASSWORD_DEFAULT);
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;
    }


    public function getSurname()
    {
        return $this->surname;
    }


    public function setSurname($surname)
    {
        $this->surname = $surname;
    }


    public function getAddress()
    {
        return $this->address;
    }


    public function setAddress($address)
    {
        $this->address = $address;
    }


    public function getIsAdmin()
    {
        return $this->is_admin;
    }


    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }

    public function verifyPassword($hashedpassword)
    {
        return password_verify($hashedpassword, $this->hashedpassword);
    }

    public function saveUser(mysqli $conn)
    {
        if ($this->id === -1) {
            $query = "INSERT INTO users (name, surname, mail, password, address)"
                . "VALUES ('{$this->name}', '{$this->surname}', '{$this->mail}', '{$this->hashedpassword}', '{$this->address}')";
            $result = $conn->query($query);

            if ($result == true) {
                $this->id = $conn->insert_id;

                return true;
            } else {
                return false;
            }
        } else {
            $query = "UPDATE users SET "
                . "mail='" . $this->getMail()
                . "', password='" . $this->getHashedPassword()
                . "', name='" . $this->getName()
                . "', surname='" . $this->getSurname()
                . "', address='" . $this->getAddress()
                . "' WHERE id='" . $this->getId() . "'";
            $result = $conn->query($query);
            return $result;
        }
    }

    public static function getUser(mysqli $conn, $id)
    {
        $id = $conn->real_escape_string($id);

        $query = "SELECT * FROM users WHERE id = '$id'";

        $result = $conn->query($query);

        if (!$result) {
            die('Error: ' . $conn->error);
        }

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
        } else {
            return null;
        }

        $user = new User(
            $row['name'],
            $row['surname'],
            $row['mail'],
            $row['password'],
            $row['address'],
            $row['is_admin'],
            $row['id']
        );

        return $user;
    }


    public static function getAllUsers(mysqli $conn)
    {
        $query = 'SELECT * FROM users';

        $result = $conn->query($query);

        if (!$result) {
            die('Error: ' . $conn->error);
        }

        $users = [];

        foreach ($result as $user) {
            $userObj = new User(
                $row['name'],
                $row['surname'],
                $row['mail'],
                $row['password'],
                $row['address'],
                $row['is_admin'],
                $row['id']
            );

            $users[] = $userObj;
        }

        return $users;
    }

    public static function logIn(mysqli $conn, $email, $password)
    {
        $email = $conn->real_escape_string($email);
        $query = "SELECT * FROM users WHERE mail='$email'";
        $result = $conn->query($query);
        if (true == $result) {
            if (1 == $result->num_rows) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $user = new User(
                        $row['name'],
                        $row['surname'],
                        $row['mail'],
                        $row['password'],
                        $row['address'],
                        $row['is_admin'],
                        $row['id']
                    );
                    return $user;
                }
            } else {
                return false;
            }
        }
    }

    public function getAllMessages($conn)
    {
        $query = "SELECT * FROM messages WHERE user_id='{$this->id}'  or admin_id='{$this->id}' ORDER BY `date` DESC";
        $result = $conn->query($query);
        if (!$result) {
            die('Error: ' . $conn->error);
        }
        $messages = [];
        if (0 < $result->num_rows) {
            foreach ($result as $message) {
                $messageObj = new Message(
                    $message['user_id'],
                    $message['admin_id'],
                    $message['text'],
                    $message['date'],
                    $message['id']
                );
                $messages[] = $messageObj;
            }
            return $messages;
        } else {
            return false;
        }
    }

    public function getAllOrders($conn)
    {
        $query = "SELECT * FROM orders WHERE user_id='{$this->id}'  ORDER BY `date` DESC";
        $result = $conn->query($query);
        if (!$result) {
            die('Error: ' . $conn->error);
        }
        $orders = [];
        if (0 < $result->num_rows) {
            foreach ($result as $order) {
                $orderObj = new Order(
                    $order['user_id'],
                    $order['status'],
                    $order['sum'],
                    $order['date'],
                    $order['id']
                );
                $orders[] = $orderObj;
            }
            return $orders;
        } else {
            return false;
        }
    }


}

;











