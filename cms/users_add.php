<?php



include ('includes/database.php');
include ('includes/config.php');
include ('includes/functions.php');
secure();
include ('includes/header.php');

if (isset($_POST['username'])) {

    if ($stm = $connect->prepare('INSERT INTO users (username, email, password, activity) VALUES (?, ?, ?, ?)')) {
        $hashed = SHA1($_POST['password']);
        $stm->bind_param('ssss', $_POST['username'], $_POST['email'], $hashed, $_POST['activity']);
        $stm->execute();

        set_message("A new user " . $_SESSION['username'] . " has been added.");

        header('Location: users.php');
        $stm->close();
        die();

    }
    else {
        echo 'Could Not prepare statement';
    }


}

 
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Add User</h1>
            <form method="post">
                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control" />
                    <label class="form-label" for="email">Username</label>
                </div>
                 <!-- Email input -->
                 <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Activity select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <select name="activity" class="form-select" id="activity">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>



                    </select>


                </div>

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add User</button>
            </form>



        </div>
    </div>
</div>








<?php


include ('includes/footer.php');

?>