<?php



include ('includes/database.php');
include ('includes/config.php');
include ('includes/functions.php');
secure();
include ('includes/header.php');


if (isset($_GET['delete'])) {
    if ($stm = $connect->prepare('DELETE FROM users where accID = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("User " . $_GET['delete'] . " has been deleted.");

        header('Location: users.php');
        $stm->close();
        die();

    }
    else {
        echo 'Could Not prepare statement';
    }

}


if ($stm = $connect->prepare('SELECT * FROM users')) {
    $stm->execute();

    $result = $stm->get_result();

    if ($result->num_rows > 0) {
 
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Users management</h1>
            <table class = "table table-striped table-hover">
                <tr>
                    <th>accID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Activity</th>
                    <th>Edit | Delete</th>


                </tr>

                <?php while($record = mysqli_fetch_assoc($result)) { ?>
                <tr>

                    <td><?php echo $record['accID']; ?> </td>
                    <td><?php echo $record['username']; ?> </td>
                    <td><?php echo $record['email']; ?> </td>
                    <td><?php echo $record['activity']; ?> </td>
                    <td><a href="users_edit.php?accID=<?php echo $record['accID']; ?>">Edit</a> | 
                        <a href="users.php?delete=<?php echo $record['accID']; ?>">Delete</a></td>
                </tr>

                <?php } ?>
            </table>

            <a href="users_add.php"> Add new user </a>


        </div>
    </div>
</div>








<?php


    } 
    else {
        echo 'no users found';

    }
$stm->close();

}
else {
    echo 'Could Not prepare statement';
}




include ('includes/footer.php');

?>