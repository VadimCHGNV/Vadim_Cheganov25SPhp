<?php
require_once 'config.php';
require_once 'functions.php';
 require_login();

 $search = trim($_GET['search'] ?? '');

// building query safely
if ($search !== '') {
    $like = '%' . $search . '%';
    $stmt = mysqli_prepare($conn, "SELECT id, name, description, price, image FROM app_products WHERE name LIKE ? ORDER BY created_at DESC");
    mysqli_stmt_bind_param($stmt, 's', $like);
} else {
    $stmt = mysqli_prepare($conn, "SELECT id, name, description, price, image FROM app_products ORDER BY created_at DESC");
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<?php include 'includes/header.php'; ?>

    <!-- search form -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form class="search-form" method="get" action="">
        
            <div class="input-group">
        
              <input type="search" name="search" class="form-control" placeholder="Search by name" value="<?php echo e($search); ?>">
        
            <button class="btn btn-primary" type="submit">Search</button>
        
        </div>
        
    </form>
          </div>
    </div>

    <!-- products grid -->
    <div class="dashboard-grid">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
             <div class="product-card">
          
               <div class="product-img">
          
             <img src="<?php echo UPLOAD_DIR_WEB . e($row['image']); ?>" alt="<?php echo e($row['name']); ?>">
            
            </div>
          
            <div class="product-info">
          
            <h3 class="product-name"><?php echo e($row['name']); ?></h3>
                      <p class="product-description"><?php echo e($row['description']); ?></p>
                 
                        <p class="product-price">$<?php echo number_format($row['price'], 2); ?></p>
              
                    <div class="card-actions">
               
                       <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
               
                      <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
               
                     </div>
                  </div>
             </div>
          <?php
         } ?>
    </div>

<?php include 'includes/footer.php'; ?>