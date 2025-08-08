<?php

// add new product with validated image upload

require_once 'config.php';
require_once 'functions.php';
require_login();

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
        // handle image
        $uploaded = handle_image_upload('image');
        if ($uploaded === false) {
            $error = $upload_error ?? 'image upload error';
        } else {
            // insert into db using prepared statement
            $stmt = mysqli_prepare($conn, "INSERT INTO app_products (name, description, price, image) VALUES (?, ?, ?, ?)");
            $price_val = number_format((float)$price, 2, '.', '');
              mysqli_stmt_bind_param($stmt, 'ssds', $name, $description, $price_val, $uploaded);
            if (mysqli_stmt_execute($stmt)) {
                set_flash('success', 'product added successfully');
                header('location: dashboard.php');
                exit;
            } else {
                // if db failed remove uploaded file 
                if ($uploaded && $uploaded !== DEFAULT_IMAGE) {
                    remove_image_file($uploaded);
                }
                $error = 'database error: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
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
                           <input name="name" class="form-control" required>
                    </div>
                        <div class="mb-3">
                            <label class="form-label">description</label>
                           <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                       <div class="mb-3">
                      
                       <label class="form-label">price</label>
                      
                       <input name="price" type="number" step="0.01" class="form-control" required>
                     
                    </div>
                    
                    <div class="mb-3">
                          <label class="form-label">image (max 2mb)</label>
                            <input name="image" type="file" accept="image/*" class="form-control">
                     </div>
                        <button class="btn btn-primary" type="submit">add product</button>
                        <a href="dashboard.php" class="btn btn-secondary">cancel</a>
                </form>
              </div>
          </div>
      </div>

<?php include 'includes/footer.php'; ?>