<?php
require_once '../libraries/Database.php';

class User
{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function findByUsername($username)
    {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function register($data)
    {
        $this->db->query('INSERT INTO users VALUES (uuid(), :username, :pwd)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':pwd', $data['pwd']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $pwd)
    {
        $row = $this->findByUsername($username);

        if ($row == false) return false;

        $hashedPwd = $row->password;
        if (password_verify($pwd, $hashedPwd)) {
            return $row;
        } else {
            return false;
        }
    }
}
