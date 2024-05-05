<?php 
    include('sidebar.php');
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Add Sport News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Post Type</label>
                                        <select class="form-select" name="post_type">
                                            <option value=""></option>
                                            <option value="Sport">Sport</option>
                                            <option value="Socail">Socail</option>
                                            <option value="Intertainment">Intertainment</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Categories</label>
                                        <select class="form-select" name="category">
                                            <option value=""></option>
                                            <option value="National">National</option>
                                            <option value="International">International</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        <input type="file" name="thumbnail" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Banner</label>
                                        <input type="file" name="banner" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="discription" id=""></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="add-news" class="btn btn-primary">Post</button>
                                        <button type="submit" class="btn btn-danger">Cancel</button>
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