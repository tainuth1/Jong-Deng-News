<?php

    $connection = new mysqli("localhost", "root", "", "news");

    function Register(){

        global $connection;

        if(isset($_POST['btn_register'])){
            $username = $_POST['_username'];
            $email    = $_POST['_email'];
            $password = $_POST['_password'];
            $profile  = $_FILES['_profile']['name'];

            if(!empty($username) && !empty($email) && !empty($password) && !empty($profile)){

                $thumbnail = date('YmdHis').'-'.$profile;
                $path = './assets/image/'.$thumbnail;

                move_uploaded_file($_FILES['_profile']['tmp_name'], $path);

                $sql = "INSERT INTO `user`(`name`, `email`, `password`, `profile`)
                    VALUES ('$username','$email','$password','$thumbnail')";

                $result = $connection->query($sql);

                if($result){
                    '<script>alert("Register successfully");</script>';
                    header('location: login.php');
                }

            }

        }

    }
    Register();

    function Login(){
        
        global $connection;
        session_start();
        if(isset($_POST['btn_login'])){

            $name_email = $_POST['name_email'];
            $login_pass = $_POST['password'];

            if(!empty($name_email) && !empty($login_pass)){

                $sql = "SELECT * FROM `user` 
                        WHERE (`name` = '$name_email' OR `email` = '$name_email')
                        && `password` = '$login_pass';
                        ";

                $result = $connection->query($sql);

                if($result){

                    $row = mysqli_fetch_assoc($result);
                    $login_id = $row['id'];

                    $_SESSION['id'] = $login_id;
                    header('location: index.php');
                }
            }
            
        }

    }
    Login();

    function logout(){
        global $connection;

        if(isset($_POST['confirm_logout'])){
            unset($_SESSION['id']);
        }
    }
    logout();

    function add_logo(){

        global $connection;

        if(isset($_POST['add-logo-btn'])){
            $logoName = $_FILES['file-logo']['name'];
            $location  = $_POST['location'];
            
            if(!empty($logoName) && !empty($location)){

                $thumbnail = date('YmdHis').'-'.$logoName;
                $path = './assets/logo/'.$thumbnail;

                move_uploaded_file($_FILES['file-logo']['tmp_name'], $path);
                $sql = "INSERT INTO `logo`(`location`, `thumbnail`) 
                        VALUE('$location', '$thumbnail');
                    ";

                $result = $connection->query($sql);

                if($result){
                    echo "<script>alert('Change Logo Successfully!');</script>";
                }else{
                    echo "<script>alert('Change Logo Fail!');</script>";
                }

            }
        }

    }
    add_logo();

    function showLogo(){

        global $connection;

        $sql = "SELECT * FROM `logo` WHERE 1 ORDER BY `id` DESC;";

        $result = $connection->query($sql);

        while($row = mysqli_fetch_assoc($result)){
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <img style="width: 60px; height: 60px; object-fit: cover;" src="./assets/logo/<?php echo $row['thumbnail'] ?>" alt="<?php echo $row['thumbnail'] ?>"/>
                    </td>
                    <td><?php echo $row['location'] ?></td>
                    <td><?php echo $row['date'] ?></td>
                    <td width="150px">
                        <a href="update-logo.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Update</a>
                        <button type="button" remove-id="<?php echo $row['id'] ?>" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Remove
                        </button>
                    </td>
                </tr>
            <?php
        }

    }

    function update_logo(){
        global $connection;
        if(isset($_POST['update-logo-btn'])){
            $id_to_update = $_POST['id_to_update'];
            $new_location = $_POST['location'];
            $new_thumbnail = $_FILES['file-logo']['name'];
            $old_thumbnail = $_POST['old_thumbnail'];

            if(empty($new_thumbnail)){
                $thumbnail = $old_thumbnail;
            }else{
                $thumbnail = date('YmdHis').'-'.$new_thumbnail;
                $path = "./assets/logo/".$thumbnail;
                move_uploaded_file($_FILES['file-logo']['tmp_name'], $path);
            }

            if(!empty($new_location)){
                $sql = "UPDATE `logo` SET `thumbnail`='$thumbnail', `location`='$new_location' WHERE `id` = '$id_to_update'";

                $result = $connection->query($sql);

                if($result){
                    echo '<script>alert("Update Successfully.");</script>';
                }
            }

        }
    }
    update_logo();

    function deleteLogo(){
        global $connection;

        if(isset($_POST['delete_btn'])){
            $id_to_delete = $_POST['remove_id'];

            $sql = "DELETE FROM `logo` WHERE `id` = '$id_to_delete'";

            $result = $connection->query($sql);

            if($result){
                echo '<script>alert("Delete Successfully.");</script>';
            }
        }
    }
    deleteLogo();

    function upload_news($new_name){
        $photo = date('YmdHis') .'-'. $new_name['name'];
        $path  = 'assets/news/'.$photo;
        
        move_uploaded_file($new_name['tmp_name'],$path);
        return $photo;
    }
    function post_news(){
        global $connection;

        if(isset($_POST['add-news'])){

            $title = $_POST['title'];
            $postType = $_POST['post_type'];
            $category = $_POST['category'];
            $thumbnail = $_FILES['thumbnail'];
            $banner = $_FILES['banner'];
            $discription = $_POST['discription'];
            $postBy = $_SESSION['id'];

            if(!empty($title) && !empty($postType) && !empty($category) && !empty( $thumbnail) && !empty($banner) && !empty($discription) ){

                $thumbnail = upload_news($thumbnail);
                $banner = upload_news($banner);

                $sql = "INSERT INTO `news`(`newsThumbnail`, `newsBanner`, `newsTitle`, `description`, `postType`, `category`, `post_by`) 
                        VALUES ('$thumbnail','$banner','$title','$discription','$postType','$category', '$postBy')";

                $result = $connection->query($sql);

                if($result){
                    echo '<script>alert("Post News Successfully.");</script>';
                }

            }else{
                echo '<script>alert("All Field must be fill.");</script>';
            }

        }

    }
    post_news();

    function view_news(){
        global $connection;
        $user = $_SESSION['id']; 

        $sql = "SELECT * FROM `user` AS a INNER JOIN `news` AS b ON a.id = b.post_by WHERE `post_by` = '$user'";

        $result = $connection->query($sql);

        while($row = mysqli_fetch_assoc($result)){
            ?>
                <tr>
                    <td><?php echo $row['newsTitle'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['postType'] ?></td>
                    <td><?php echo $row['category'] ?></td>
                    <td><img style="width: 100px; aspect-ratio: 16 / 9; object-fit: cover;" src="assets/news/<?php echo $row['newsThumbnail'] ?>"/></td>
                    <td><img style="width: 100px; aspect-ratio: 16 / 9; object-fit: cover;" src="assets/news/<?php echo $row['newsBanner'] ?>"/></td>
                    <td class="truncate-text"><?php echo $row['description'] ?></td>
                    <td><?php echo $row['date'] ?></td>
                    <td width="150px">
                        <a href=""class="btn btn-primary">Update</a>
                        <button type="button" remove-id="1" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Remove
                        </button>
                    </td>
                </tr>
            <?php
        }

    }
    
?>