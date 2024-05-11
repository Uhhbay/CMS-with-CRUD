<?php



include ('includes/database.php');
include ('includes/config.php');
include ('includes/functions.php');
secure();
include ('includes/header.php');

if (isset($_POST['username'])) {
    if ($stm = $connect->prepare('UPDATE users set username = ?, email = ?, activity = ? WHERE accID = ?')) {
        $stm->bind_param('sssi', $_POST['username'], $_POST['email'], $_POST['activity'], $_GET['accID']);
        $stm->execute();

        $stm->close();


        if (isset($_POST['password'])) { 
            if ($stm = $connect->prepare('UPDATE users set password = ? WHERE accID = ?')) {
                $hashed = SHA1($_POST['password']);
                $stm->bind_param('si', $hashed, $_GET['accID']);
                $stm->execute();
                $stm->close(); 
            }
            else {
                echo 'Could Not prepare password update statement';
            }
    
    
        }
        

        set_message("User " . $_GET['accID'] . " has been updated.");
        header('Location: users.php');
        die();

    }
    else {
        echo 'Could Not prepare user update statement';
    }


}

if (isset($_GET['accID'])) {
    if ($stm = $connect->prepare('SELECT * from users WHERE accID = ?')) {
        $stm->bind_param('i', $_GET['accID']);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if ($user) {



 
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Edit User</h1>
            <form method="post">
                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control active" value="<?php echo $user['username'] ?>"/>
                    <label class="form-label" for="email">Username</label>
                </div>
                 <!-- Email input -->
                 <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control active" value="<?php echo $user['email'] ?>"/>
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="form1Example2">Password</label>
                </div>

                <!-- Activity select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <select name="activity" class="form-select" id="activity">
                        <option <?php echo ($user['activity']) ? "selected" : ""; ?> value="1">Active</option>
                        <option <?php echo ($user['activity']) ? "" : "selected"; ?> value="0">Inactive</option>



                    </select>


                </div>

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Update User</button>
            </form>



        </div>
    </div>
</div>








<?php

}
$stm->close();

}
else {
echo 'Could Not prepare statement';
}


} 
else {
echo "No user selected";
die();
}


include ('includes/footer.php');

?>