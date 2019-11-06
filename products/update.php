<?php
$page_title = "Update Product";
include_once(__DIR__ . '/../layouts/header.php');
include_once(__DIR__ . '/../layouts/_top_bar.php');
include_once(__DIR__ . '/../classes/product.php');
include_once(__DIR__ . '/../classes/category.php');
$product  = new Product();
$category = new Category();

if (isset($_POST['submit_update']) && (isset($_GET['product']) && filter_var($_GET['product'], FILTER_VALIDATE_INT))) {
    $product->id = (int) $_GET['product'];
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];
    $image = !empty($_FILES['image']['name']) ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES['image']['name']) : $_SESSION['old_image'];
    $product->image = $image;

    if ($product->update()) {
        // $_SESSION['action'] = true;
        // $_SESSION['message '] = 'product updated successfully';
        // $_SESSION['class'] = 'success';

        echo "<div class='alert alert-success' > success</div>";
        if ($image != $_SESSION['old_image']) {   
            echo $product->uploadPhoto();
        }
    } else {
        echo $product->all_error;
    }
}

?>
<!--  -->
<?php


if (isset($_GET['product']) && filter_var($_GET['product'], FILTER_VALIDATE_INT)) {



    $product->id = (int) $_GET['product'];
    $stmt = $product->readOne();



    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //     $category->id = $row['category_id'];
        //    echo  $category->readName();
        $_SESSION['old_image'] =  $row['image'];
        ?>
        <form method="post" action="update.php?product=<?php echo $row['id'] ?>" enctype="multipart/form-data">
            <table class="table  table-bordered create-form">
                <tr>
                    <th>Name</th>
                    <td><input type="text" value="<?php echo $row['name']; ?>" name="name"></td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td><input type="number" value="<?php echo $row['price']; ?>" name="price"></td>
                </tr>


                <tr>
                    <th>Category</th>
                    <td>
                        <!--            read all categories-->
                        <select name="category_id">
                            <option value="">Select Category</option>

                            <?php
                                    $stmt = $category->read();
                                    while ($row_cat = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row_cat);
                                        echo  $id === $row['category_id'] ? "<option value='{$id}' selected>{$name}</option>" : "<option value='{$id}'>{$name}</option>";
                                    }
                                    ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><textarea name="description"><?php echo $row['description']; ?></textarea></td>
                </tr>
                <tr>
                    <th>Photo</th>
                    <td>
                        <img src="<?php echo $host . 'uploads/' . $row['image']; ?>" class="w-50 img-thumbnail">
                        <input type="file" accept="image/*" name="image">
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-success" name="submit_update">Update</button>
        </form>
<?php
    }
} else {
    header('location: /products/');
}
include_once(__DIR__ . '/../layouts/footer.php'); ?>