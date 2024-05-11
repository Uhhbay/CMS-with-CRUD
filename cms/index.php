<?php



include ('includes/database.php');
include ('includes/config.php');
include ('includes/functions.php');
include ('includes/header.php');

if (isset($_SESSION['accID'])) {
    header('Location: dashboard.php');
    die();
}

if (isset($_POST['email'])) {
    if ($stm = $connect->prepare('SELECT * FROM users WHERE email = ? AND password = ? AND activity = 1')) {
        $hashed = SHA1($_POST['password']);
        $stm->bind_param('ss', $_POST['email'], $hashed);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $_SESSION['accID'] = $user['accID'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            set_message("You have successfully logged in " . $_SESSION['username']);

            header('Location: dashboard.php');
            die();
        }
        $stm->close();

    }
    else {
        echo 'Could Not prepare statement';
    }
}


?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form method="post">
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="form1Example2">Password</label>
                </div>



                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>


        </div>
    </div>
</div>








<?php
include ('includes/footer.php');

?>