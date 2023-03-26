<?php
  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "form";
  //echo "PHP";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // Get the form data
  $first_name = $_POST['firstName'];
  $last_name = $_POST['lastName'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $phone_no = $_POST['phoneNumber'];
  $jamb_reg = $_POST['jambNumber'];
  $program = $_POST['programme'];
  
    // Check if the uploaded file is an image
    //$check = getimagesize($_FILES["image"]["tmp_name"]);
    //if ($check !== false) {
      // Store the image in your server's file system
    $target_dir = "uploads/";
    $passport_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $passport_file);

    //get image file of key oLevelResult and get imageName
    $olevel_file = $target_dir . basename($_FILES["oLevelResult"]["name"]);
    move_uploaded_file($_FILES["oLevelResult"]["tmp_name"], $olevel_file);
  
    // Store the path to the image in the database
    $passport_path = $passport_file;
    $olevel_path = $olevel_file;
      

  // Insert the form data into the database
  $sql = "INSERT INTO form_data (firstName, lastName, email, address, phoneNumber, jambNumber, programme, passportPath, oLevelResultPath) 
  VALUES ('$first_name', '$last_name', '$email', '$address', '$phone_no', '$jamb_reg', '$program','$passport_path','$olevel_path')";

      $data = array(
        'firstName' => $first_name, 'lastName' => $last_name, 
        'email'=> $email, 'address'=>$address,
        'phoneNumber' => $phone_no , 'jambNumber' => $jamb_reg, 
        'programme'=> $program, 'passportPath' => $passport_path, 
        'olevel_path' => $olevel_path
      );

      $json = json_encode($data);

      // Set the content type to JSON
      header('Content-Type: application/json');
      
      //set the content type to JSON

  if (mysqli_query($conn, $sql)) {
      header('Content-Type: text/html');
      echo "
          <html>
              <head>
                <style>
                  .container {
                    text-align: center;
                  }
                  img {
                    border-radius: 50%;
                    height: 300px;
                    width: 300px;
                  }
                  h2{
                    margin: 0px;
                  }
                  h4{
                    margin-bottom: 0px;
                    color: darkgray;
                    font-style: initial;
                    font-family: cursive;
                    }
                  }
                </style>
              </head>
              <body>
                <div class=\"container\">
                  <h1>Submission Successful!</h1>
                  <img src = \" $passport_path\">
                  <h4>First Name</h4>
                  <h2>$first_name</h2>
                  <h4>Last Name</h4>
                  <h2>$last_name</h2>
                  <h4>Program</h4>
                  <h2>$program</h2>
                  <h4>Email Address</h4>
                  <h2>$email</h2>
                </div>
              </body>
          </html>
      
      ";

  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  // Close the database connection
  mysqli_close($conn);
?>
