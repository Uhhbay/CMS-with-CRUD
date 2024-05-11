<?php 

function secure() {
    if(!isset($_SESSION['accID'])) {
        set_message("Please log in first.");
        header('Location: /cms');
        die();
    }

}

function set_message($message) {
    {
        $_SESSION['message'] = $message;
    }
}

function get_message() {
    if(isset($_SESSION['message'])) {
        //echo '<p>' . $_SESSION['message'] . '</p> <hr>';
        echo "<script type='text/javascript'> showToast('" . $_SESSION['message'] . "', 'top center', 'success') </script>";
        unset($_SESSION['message']);

    }
}