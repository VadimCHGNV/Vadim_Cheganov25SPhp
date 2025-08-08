<?php

// edit product details and optionally replace image

require_once 'config.php';
require_once 'functions.php';
require_login();

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('location: dashboard.php');
    exit;
}

// fetch product
$stmt = mysqli_prepare($conn, "SELECT id, name, description, price, image FROM app_products WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$product) {
    set_flash('danger', 'product not found');
    header('location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');

    if ($name === '' || $description === '' || $price === '') {
        $error = 'please fill in all fields';
    } elseif (!is_numeric($price) || floatval($price) < 0) {
        $error = 'price must be a positive number';
    } else {
        $new_image = null;
        // if new file uploaded, handle it
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploaded = handle_image_upload('image');
            if ($uploaded === false) {
                $error = $upload_error ?? 'image upload error';
            } else {
                $new_image = $uploaded;
            }
        }

        if ($error === '') {
            // update query
            if ($new_image !== null) {
                $stmt2 = mysqli_prepare($conn, "UPDATE app_products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
                 $price_val = number_format((float)$price, 2, '.', '');
              
                 mysqli_stmt_bind_param($stmt2, 'ssdsi', $name, $description, $price_val, $new_image, $id);
            } 
            else {
                $stmt2 = mysqli_prepare($conn, "UPDATE app_products SET name = ?, description = ?, price = ? WHERE id = ?");
                $price_val = number_format((float)$price, 2, '.', '');
                mysqli_stmt_bind_param($stmt2, 'ssdi', $name, $description, $price_val, $id);
            }

            if (mysqli_stmt_execute($stmt2)) {
                // if we added a new image, remove old file
            
                if ($new_image !== null && $product['image'] && $product['image'] !== DEFAULT_IMAGE) {
                    remove_image_file($product['image']);
                }
                set_flash('success', 'product updated successfully');
                header('location: dashboard.php');
                exit;
            }
             else {
                $error = 'database error: ' . mysqli_error($conn);
                // cleanup uploaded file on failure
                if ($new_image !== null) {
                     remove_image_file($new_image);
                  }
            }
            mysqli_stmt_close($stmt2);
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

    <?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card p-4">
                <form method="post" enctype="multipart/form-data" action="">
                    <div class="mb-3">
                        <label class="form-label">product name</label>
            
                        <input name="name" class="form-control" value="<?php echo e($product['name']); ?>" required>
                    </div>
                     <div class="mb-3">
            
                    <label class="form-label">description</label>
                        <textarea name="description" class="form-control" rows="4" required><?php echo e($product['description']); ?></textarea>
                      </div>
                     <div class="mb-3">
                         <label class="form-label">price</label>
             
                         <input name="price" type="number" step="0.01" class="form-control" value="<?php echo e($product['price']); ?>" required>
                     </div>

                    <div class="mb-3">
                        <label class="form-label">replace image (optional)</label>
                 
                        <input name="image" type="file" accept="image/*" class="form-control">
                            <div class="mt-2">
                            <strong>current:</strong><br>
                            <img src="<?php echo UPLOAD_DIR_WEB . e($product['image']); ?>" alt="current" style="max-width:120px;">
                        </div>
                    </div>

                        <button class="btn btn-primary" type="submit">update product</button>
                     <a href="dashboard.php" class="btn btn-secondary">cancel</a>
                    </form>
                </div>
               </div>
    </div>

<?php include 'includes/footer.php'; ?>