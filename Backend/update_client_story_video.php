<?php
$con = mysqli_connect("localhost", "root", "Anushka@25", "pr_project");

if (!$con) {
    die('error in db' . mysqli_error($con));
}

// Variables to store form data
$csv_client = $csv_event = $csv_link = $cs_desc = $cs_status = '';

// Fetch data for editing when the page loads
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $check_query = "SELECT * FROM pr_client_story_videos WHERE pr_csv_id = $id";

    $check_query_sql    = mysqli_query($con, $check_query);
    $count_check_query  = mysqli_num_rows($check_query_sql);

    if ($count_check_query > 0) {
        $row                    = $check_query_sql->fetch_assoc();
        $csv_id                 = $row['pr_csv_id'];
        $csv_client             = $row['pr_csv_client'];
        $csv_event              = $row['pr_csv_event'];
        $csv_link               = $row['pr_csv_link'];
        $cs_desc                = $row['pr_cs_desc'];
        $cs_status             = $row['pr_cs_status'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve form fields
    $csv_client             = isset($_POST['csv_client']) ? $_POST['csv_client'] : '';
    $csv_event              = isset($_POST['csv_event']) ? $_POST['csv_event'] : '';
    $csv_link               = isset($_POST['csv_link']) ? $_POST['csv_link'] : '';
    $cs_desc                = isset($_POST['cs_desc']) ? $_POST['cs_desc'] : '';
    $cs_status              = isset($_POST['cs_status']) ? $_POST['cs_status'] : '';

    // Extract YouTube video ID from the link
    $youtube_link = isset($_POST['csv_link']) ? $_POST['csv_link'] : '';
    $video_id = '';
    if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $youtube_link, $match)) {
        $video_id = $match[1];

        // Update data in the database
        $update_client_story_videos_query = "UPDATE pr_client_story_videos SET 
                                    pr_csv_client           = '$csv_client', 
                                    pr_csv_event            = '$csv_event', 
                                    pr_csv_link             = '$video_id', 
                                    pr_cs_desc              = '$cs_desc', 
                                    pr_cs_status            = '$cs_status'
                                    
                                WHERE pr_csv_id = '$csv_id'";

        
        if (mysqli_query($con, $update_client_story_videos_query)) {
            echo'<script>alert("Client Story Videos Updated Successfully");</script>';
            header('location: insert_client_story_video.php');
        } else {
            echo "Error: " . $update_client_story_videos_query . "<br>" . mysqli_error($con);
        }
    } 
    elseif (preg_match('/^[a-zA-Z0-9_-]{11}$/', $youtube_link)) {
        // If the input is only the video ID
        $video_id = $youtube_link;
        // Update data in the database
        $update_client_story_videos_query = "UPDATE pr_client_story_videos SET 
                                    pr_csv_client           = '$csv_client', 
                                    pr_csv_event            = '$csv_event', 
                                    pr_csv_link             = '$video_id', 
                                    pr_cs_desc              = '$cs_desc', 
                                    pr_cs_status            = '$cs_status'
                                    
                                WHERE pr_csv_id = '$csv_id'";

        
        if (mysqli_query($con, $update_client_story_videos_query)) {
            echo'<script>alert("Client Story Videos Updated Successfully");</script>';
            header('location: insert_client_story_video.php');
        } else {
            echo "Error: " . $update_client_story_videos_query . "<br>" . mysqli_error($con);
        }
    }   
    else {
        echo'<script>alert("Is not a YouTube Link");</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client Story Videos</title>
    <!-- Your custom CSS -->
    <link rel="stylesheet" href="../Styles/insert_client_story_video.css">
    <!-- YouTube Lite CSS -->
    <link rel="stylesheet" href="../Styles/lite-yt-embed.css">
    <script src="./lite-yt-embed.js"></script>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <div class="wrapper">
            <input type="hidden" name="csv_id" value="<?php echo $csv_id; ?>">
            
            <div class="form-row">
                <label for="pr_csv_client">Client</label>
                <input type="number" name="csv_client" id="pr_csv_client" value="<?php echo $csv_client ?>" >
            </div>

            <div class="form-row">
                <label for="pr_csv_event">Event</label>
                <input type="number" name="csv_event" id="pr_csv_event" value="<?php echo $csv_event ?>" >
            </div>

            <div class="form-row">
                <label for="pr_csv_link">Link</label>
                <input type="text" name="csv_link" id="pr_csv_link" value= "<?php echo $csv_link ?>" />
            </div>

            <div class="form-row">
                <label for="pr_cs_desc">Description</label>
                <textarea type="text" name="cs_desc" id="pr_cs_desc"><?php echo $cs_desc ?></textarea>

            </div>

            <div class="form-row">
                <label for="pr_cs_status">Status</label>
                <input type="number" name="cs_status" id="pr_cs_status" value="<?php echo $cs_status ?>" >
            </div>

            <div class="buttonSubmit">
                <input type="submit" name="update" value="Update">
            </div>
        </div>
    </form>
</body>
</html>
