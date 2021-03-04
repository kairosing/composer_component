<?php
namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;


class HomeController{

    private $templates;
    private $db;

    public function __construct()
    {
       $this->templates = new Engine('../app/views');
       $this->db = new QueryBuilder();
    }



    public function index($vars){

        $users = $this->db->getAll('users');
        echo $this->templates->render('homepage', ['postsInView' => $users]);

}


    public function about($vars){

        echo $this->templates->render('about', ['users' => 'tr']);

}

    public function edit($vars){

        $users = $this->db->getOne('users', $vars['id']);
        echo $this->templates->render('edit', ['user' => $users]);

    }

    public function action_user($vars){

        $users = $this->db->getOne('users', $vars['id']);
        echo $this->templates->render('edit', ['user' => $users]);

    }


    public function edit_user()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $id = $_POST['id'];

        $successful = $this->db->update([
            'username' => $username,
            'email' => $email],
            $id, 'users'
        );
        if (!$successful){
            Flash::message('User update', 'success');
        } else{
            Flash::message('Something went wrong', 'error');
        }

        header('Location: /home');
    }

    public function create_user(){
        echo $this->templates->render('create');
    }

    public function create_user_handler()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];

        $this->db->insert(['username' => $username, 'email' => $email], 'users');

        header('Location: /home');
    }

    public function delete_user($vars){
        $users = $this->db->delete('users', $vars['id']);
       if ($users) {
           Flash::message('User deleted', 'success');
       }else{
           Flash::message('Unable to delete user', 'error');
       }

       header('Location: /home');


    }





}



