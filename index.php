<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" type="image/x-icon" href="assets/imgs/logo.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>

    <!-- Bara Navigatie -->
<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-light bg-white py-2">
  <div class="container">
      <a class="navbar-brand" href="#">
          <img src="assets/imgs/logo.jpeg" alt="Logo" style="height: 40px;">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Main Links -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link" href="index.php">Acasa</a>
              </li>
          </ul>
          <!-- User Links -->
          <ul class="navbar-nav ml-auto mb-2 mb-lg-0">

              <li class="nav-item">
                  <a href="cos.html" class="nav-link">
                      <i class="fas fa-solid fa-cart-shopping"></i>
                      <span class="text-smaller">Cosul meu</span>
                  </a>
              </li>
              <li class="nav-item">
                <a href="cont.html" class="nav-link">
                    <i class="fas fa-solid fa-user"></i>
                </a>
            </li>
          </ul>
      </div>
  </div>
</nav>

<!-- BARA -->

<nav class="prodbar navbar-expand-lg category-bar">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categoryNavbar" aria-controls="categoryNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="categoryNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="produseDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" >
                        ☰ Produse
                    </a>
                    <div class="dropdown-menu" aria-labelledby="produseDropdown">
                        <a class="dropdown-item" href="telefoane.html">Telefoane</a>
                        <a class="dropdown-item" href="laptopuri.html">Laptopuri</a>
                        <a class="dropdown-item" href="monitoare.html">Monitoare</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Suport Clienti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Magazine</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Home -->
<section id="home">
    <div class="container text-center text-md-start">
        <h5><strong>SUPER CATALOG!</strong></h5>
        <h1><span>SUPER PRETURI</span> pentru cei mici si cei mari!</h1>
        <p>Oferim cele mai mici preturi!</p>
        <button class="btn btn-primary">Vezi aici catalogul</button>
    </div>
</section>

<!-- TEXT PARTENERI -->
<section id="parteneri" class="text-center my-5">
    <h2>PARTENERI</h2>
</section>

<!-- Branduri -->
<section id="brand" class="container">
    <div class="row justify-content-center p-0 m-0">
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 p-2">
            <img class="img-fluid" src="assets/imgs/brand1.jpeg" alt="Brand 1"/>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 p-2">
            <img class="img-fluid" src="assets/imgs/brand2.jpeg" alt="Brand 2"/>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 p-2">
            <img class="img-fluid" src="assets/imgs/brand3.jpeg" alt="Brand 3"/>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 p-2">
            <img class="img-fluid" src="assets/imgs/brand4.jpeg" alt="Brand 4"/>
        </div>
    </div>
</section>

<!-- Nou -->

<section id="nou" class="w-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <?php 
            include('server/get_featured_products.php'); 

            echo "<!-- Checking if featured_products is set and has rows -->";

            if ($featured_products && $featured_products->num_rows > 0) {
                echo "<!-- Found " . $featured_products->num_rows . " featured products -->";
                while($row = $featured_products->fetch_assoc()) { 
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="box">
                        <img class="img-fluid" src="assets/imgs/<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product Image">
                        <div class="detalii">
                            <h2>TOP FAVORITE!</h2>
                            <p class="produsfavorit"><?php echo htmlspecialchars($row['product_name']); ?></p>
                            <div class="star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="p-pret"><?php echo htmlspecialchars($row['product_price']); ?> Lei</h4>
                            <button class="btn btn-primary vezi-produsul">Vezi produsul</button>
                        </div>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<!-- No featured products found -->";
                echo "<p>No featured products found.</p>";
            }
            ?>
        </div>
    </div>
</section>




<!-- Footer -->
<footer class="mt-5 py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <a href="https://feaa.ugal.ro/"><img src="assets/imgs/logo2.jpeg" alt="Logo" class="logo img-fluid"></a>
                <p class="pt-3">Cel mai bun raport pret-calitate</p>
                <img src="assets/imgs/plata.jpeg" class="plata img-fluid">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <h5 class="pb-2">Contacteaza-ne</h5>
                <p><strong>Adresa:</strong> Strada Garii, Nr. 123</p>
                <p><strong>Telefon:</strong> +40 123 456 789</p>
                <p><strong>Email:</strong> info@raol.com</p>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <h5 class="pb-2">Informatii</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Despre noi</a></li>
                    <li><a href="#">Termeni si conditii</a></li
