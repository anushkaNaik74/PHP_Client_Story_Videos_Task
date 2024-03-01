<?php $con = mysqli_connect("localhost", "root", "Anushka@25", "pr_project"); ?>

<?php

ob_start();

    // Variables to store form data
    $csv_client = $csv_event = $csv_link = $cs_desc = $cs_status = '';


    if(isset($_POST['submit'])){

        $csv_client                 = $_POST['pr_csv_client'];
        $csv_event                  = $_POST['pr_csv_event'];
        $csv_link                   = $_POST['pr_csv_link'];
        $cs_desc                   = $_POST['pr_cs_desc'];
        $cs_status                 = $_POST['pr_cs_status'];

        // Extract YouTube video ID from the link
        $youtube_link = $_POST['pr_csv_link'];
        $video_id = '';
        if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $youtube_link, $match)) {
            $video_id = $match[1];
       

        

        // Insert data into the database
        $insert_client_story_videos = "INSERT INTO pr_client_story_videos (
                                pr_csv_client, 
                                pr_csv_event, 
                                pr_csv_link, 
                                pr_cs_desc, 
                                pr_cs_status
                            ) VALUES (
                                '$csv_client', 
                                '$csv_event', 
                                '$video_id', 
                                '$cs_desc', 
                                '$cs_status'
                            )";

        // Execute the SQL query

        if (mysqli_query($con, $insert_client_story_videos)) {
          // Redirect to another page after successful insertion
          header('Location: insert_client_story_video.php');
          exit; // Make sure to exit after redirection
      } else {
          echo "Error: " . $insert_client_story_videos . "<br>" . mysqli_error($con);
      }
        }
        else {
          echo'<script>alert("Is not a YouTube Link");</script>';
      }
        } 
        

   ob_end_flush(); 
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
  <form id="registration_form" method="post" enctype="multipart/form-data">
    <div class="wrapper">
      <div class="form-row">
        <label for="pr_csv_client">Client</label>
        <input type="number" name="pr_csv_client" id="pr_csv_client" placeholder="Enter Client" required>
      </div>

      <div class="form-row">
        <label for="pr_csv_event">Event</label>
        <input type="number" name="pr_csv_event" id="pr_csv_event" placeholder="Enter Event" required>
      </div>

      <div class="form-row">
        <label for="pr_csv_link">Link</label>
        <input type="text" name="pr_csv_link" id="pr_csv_link" placeholder="Enter Video Link" required />

      </div>

      <div class="form-row">
        <label for="pr_cs_desc">Description</label>
        <textarea type="text" name="pr_cs_desc" id="pr_cs_desc" placeholder="Enter Description" required></textarea>

      </div>

      <div class="form-row">
        <label for="pr_cs_status">Status</label>
        <input type="number" name="pr_cs_status" id="pr_cs_status" placeholder="Enter Status">
      </div>

      <div class="buttonSubmit">
        <input type="submit" name="submit" value="Submit">
      </div>
    </div>
      
    <h3>Client Story Details</h3>
  <table>
    <tr>
      <th>#</th>
      <th>Client</th>
      <th>Event</th>
      <th>Link</th>
      <th>Description</th>
      <th>Status</th>
      <th>Operations</th>
    </tr>

    <?php
      $i = 1;
      $select_all_client_story_videos_query = "SELECT * FROM pr_client_story_videos";
      $select_all_client_story_videos_query_sql = mysqli_query($con, $select_all_client_story_videos_query);
      $count_select_all_client_story_videos_query = mysqli_num_rows($select_all_client_story_videos_query_sql);

      if($count_select_all_client_story_videos_query  > 0){
        while ($row = $select_all_client_story_videos_query_sql -> fetch_assoc()) {
          $id = $row['pr_csv_id'];
    ?>

        <tr>
        <td><?php echo $i++ ?></td>
        <td><?php echo $row['pr_csv_client']?></td>
        <td><?php echo $row['pr_csv_event']?></td>
        <td>
            <lite-youtube videoid="<?php echo $row['pr_csv_link']; ?>"></lite-youtube>
        </td>
        <td><?php echo $row['pr_cs_desc']?></td>
        <td><?php echo $row['pr_cs_status']?></td>

        <td class="operations">
            <a href="update_client_story_video.php?id=<?php echo $id; ?>" class="edit-button">Edit</a>
            <a href="delete_client_story_video.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure?')" class="delete-button">Delete</a>
        </td>
        </tr>

    <?php 
        }
      }
    ?>
  </table>
    </form>
  <?php
      $i = 1;
      $select_all_client_story_videos_query = "SELECT * FROM pr_client_story_videos";
      $select_all_client_story_videos_query_sql = mysqli_query($con, $select_all_client_story_videos_query);
      $count_select_all_client_story_videos_query = mysqli_num_rows($select_all_client_story_videos_query_sql);

      if($count_select_all_client_story_videos_query  > 0){
        while ($row = $select_all_client_story_videos_query_sql -> fetch_assoc()) {
          $id = $row['pr_csv_id'];
    ?>
      <div class="grid-container">
        <div class="grid-container-item">
          <lite-youtube videoid="<?php echo $row['pr_csv_link']; ?>"></lite-youtube>
        </div>
      </div>

    <?php 
        }
      }
    ?>

  </body>
</html>

  