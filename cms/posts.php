<?php



include ('includes/database.php');
include ('includes/config.php');
include ('includes/functions.php');
secure();
include ('includes/header.php');


if (isset($_GET['delete'])) {
    if ($stm = $connect->prepare('DELETE FROM posts where accID = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("Post has been deleted.");

        header('Location: posts.php');
        $stm->close();
        die();

    }
    else {
        echo 'Could Not prepare statement';
    }

}


if ($stm = $connect->prepare('SELECT * FROM posts')) {
    $stm->execute();

    $result = $stm->get_result();

    if ($result->num_rows > 0) {
 
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Posts management</h1>
            <table class = "table table-striped table-hover">
                <tr>
                    <th>accID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Content</th>
                    <th>Edit | Delete</th>


                </tr>

                <?php while($record = mysqli_fetch_assoc($result)) { ?>
                <tr>

                    <td><?php echo $_SESSION['accID']; ?> </td>
                    <td><?php echo $record['title']; ?> </td>
                    <td><?php echo $record['author']; ?> </td>
                    <td><?php echo $record['content']; ?> </td>
                    <td><a href="posts_edit.php?accID=<?php echo $record['accID']; ?>">Edit</a> | 
                        <a href="posts.php?delete=<?php echo $record['accID']; ?>">Delete</a></td>
                </tr>

                <?php } ?>
            </table>

            <a href="posts_add.php"> Create a post </a>


        </div>
    </div>
</div>








<?php


    } 
    else {
        echo 'no posts found';

    }
$stm->close();

}
else {
    echo 'Could Not prepare statement';
}




include ('includes/footer.php');

?>