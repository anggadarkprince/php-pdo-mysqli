<?php
// load user model
require_once '../application/UserModel.php';
require_once '../application/User.php';
$userModel = new UserModel();
$user = new User();

// handle action
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
    case 'create':
        // TODO: data validation
        // populate input from user
        $user->setFirstName($_POST['first_name']);
        $user->setLastName($_POST['last_name']);
        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);

        // save to database
        if($userModel->insert($user)){
            header('location:../index.php?action=create&status=success');
        } else {
            // TODO: populate last inputs to session
            // return back to form
            header('location:../form.php?action=create&status=failed');
        }
        break;
    case 'edit':
        // TODO: data validation
        // populate input from user
        $user->setId($_POST['id']);
        $user->setFirstName($_POST['first_name']);
        $user->setLastName($_POST['last_name']);
        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);

        // update database
        if($userModel->update($user)){
            header('location:../index.php?action=edit&status=success');
        } else {
            // TODO: populate last inputs to session
            // return back to form : no rows affected
            // header('location:../form.php?action=edit&id='.$_POST['id'].'&status=failed');
            header('location:../index.php?action=edit&status=success');
        }
        break;
    case 'delete':
        // populate input from user
        $user->setId($_POST['id']);

        // delete from database
        if($userModel->delete($user)){
            header('location:../index.php?action=delete&status=success');
        } else {
            header('location:../index.php?action=delete&status=failed');
        }
        break;
    default:
        header('location:../index.php');
        break;
}