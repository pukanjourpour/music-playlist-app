<?php

require_once '../models/User.php';
require_once '../helpers/session_helper.php';

class Users
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function register()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'username' => trim($_POST['username']),
            'pwd' => trim($_POST['pwd']),
            'pwdRepeat' => trim($_POST['pwdRepeat'])
        ];

        //Validate inputs
        if (
            empty($data['username']) || empty($data['pwd']) || empty($data['pwdRepeat'])
        ) {
            flash("register", "Some fields are empty");
            redirect(" ../signup.php");
        }

        if (!preg_match("/^[a-zA-Z0-9]*$/", $data['username'])) {
            flash("register", "Invalid username");
            redirect(" ../signup.php");
        }

        if (strlen($data['pwd']) < 6) {
            flash("register", "Invalid password");
            redirect(" ../signup.php");
        } else if ($data['pwd'] !== $data['pwdRepeat']) {
            flash("register", "Passwords don't match");
            redirect(" ../signup.php");
        }

        if ($this->userModel->findByUsername($data['username'])) {
            flash("register", "Username or email already taken");
            redirect(" ../signup.php");
        }

        $data['pwd'] = password_hash($data['pwd'], PASSWORD_DEFAULT);

        if ($this->userModel->register($data)) {
            redirect(" ../login.php");
        } else {
            die("Something went wrong");
        }
    }

    public function login()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'username' => trim($_POST['username']),
            'pwd' => trim($_POST['pwd'])
        ];

        if (empty($data['username']) || empty($data['pwd'])) {
            flash("login", "Please fill out all inputs");
            redirect(" ../login.php");
        }

        if ($this->userModel->findbyUsername($data['username'], $data['username'])) {
            $loggedInUser = $this->userModel->login($data['username'], $data['pwd']);
            if ($loggedInUser) {
                $this->createUserSession($loggedInUser);
            } else {
                flash("login", "Password Incorrect");
                redirect(" ../login.php");
            }
        } else {
            flash("login", "No user found");
            redirect(" ../login.php");
        }
    }

    public function createUserSession($user)
    {
        try {
            $_SESSION['uuidUser'] = $user->id_user;
            $_SESSION['username'] = $user->username;
        } catch (Exception $e) {
            die($e->getMessage());
        }
        redirect(" ../index.php");
    }

    public function logout()
    {
        unset($_SESSION['uuidUser']);
        unset($_SESSION['username']);
        session_destroy();
        redirect(" ../index.php");
    }
}

$init = new Users;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'register':
            $init->register();
            break;
        case 'login':
            $init->login();
            break;
        default:
            redirect("../index.php");
    }
} else {
    switch ($_GET['q']) {
        case 'logout':
            $init->logout();
            break;
        default:
            redirect("../index.php");
    }
}
