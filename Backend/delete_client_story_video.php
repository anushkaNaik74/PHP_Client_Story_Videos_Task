<?php
$con = mysqli_connect("localhost", "root", "Anushka@25", "pr_project");
if (!$con) {
    die('error in con' . mysqli_error($con));
}

$id = $_GET['id'];



$delete_client_story_videos = "DELETE FROM pr_client_story_videos WHERE pr_csv_id = $id";

if (mysqli_query($con, $delete_client_story_videos)) {
    echo '<script>alert("Client Story Videos Deleted Successfully");</script>';
    header('location: insert_client_story_video.php');
} else {
    echo mysqli_error($con);
}
?>
