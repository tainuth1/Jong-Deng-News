<?php 
    include('sidebar.php');
    $update_id = $_GET['id'];

    $sql_update_logoo = "SELECT * FROM  `logo` WHERE `id` = '$update_id';";

    $result = $connection->query($sql_update_logoo);

    $row = mysqli_fetch_assoc($result);

?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Update Logo News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select class="form-select" name="location">
                                            <option value=""></option>
                                            <option value="Header"​<?php if($row['location'] == 'Header') echo 'selected' ?>>Header</option>
                                            <option value="Footer"​​<?php if($row['location'] == 'Footer') echo 'selected' ?>>Footer</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>File</label>
                                        <input type="hidden" name="id_to_update" value="<?php echo $row['id'] ?>">
                                        <input type="file" name="file-logo" class="form-control">
                                        <input type="hidden" name="old_thumbnail" value="<?php echo $row['thumbnail'] ?>">
                                        <img style="width: 100px; height: 100px; object-fit: cover; margin-top: 10px;" src="assets/logo/<?php echo $row['thumbnail'] ?>" alt="<?php echo $row['thumbnail'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="update-logo-btn" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                                </form>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>