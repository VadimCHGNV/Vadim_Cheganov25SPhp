<?php
// startig session and include configuration
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
?>

<!-- html structure for about page -->
  <?php include 'includes/header.php'; ?>

<main class="container my-4">
     <section>
        <!-- super important about section MUST TO READ FULL!!! -->
            <h1 class="text-center mb-4">About This Project </h1>
          <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur lorem mi, egestas nec arcu eget, dignissim pulvinar sapien. Proin ut consectetur odio. Nullam eleifend ut eros eget faucibus. </p>
           <p class="text-center"> Aliquam eget dictum dui, sed dictum libero. </p>
       </section>
  </main>

 <?php include 'includes/footer.php'; ?>