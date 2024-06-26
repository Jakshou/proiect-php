<?php 
include('server/connection.php');
if(isset($_GET['product_id'])){

    $product_id = $_GET['product_id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i",$product_id);
    $stmt->execute();
    $product = $stmt->get_result();

}else{
    header('location: index.php');
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SG</title>
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
                        <a href="cos.php" class="nav-link">
                            <i class="fas fa-solid fa-cart-shopping"></i>
                            <span class="text-smaller">Cosul meu</span>
                        </a>
                    </li>
                    <li class="nav-item">
                      <a href="cont.php" class="nav-link">
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
                          <a class="nav-link dropdown-toggle" href="#" id="produseDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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


<!-- Produs       -->
<section class="container single-product  my-5 pt-5">
    <div class="row mt-5">

    <?php while($row = $product->fetch_assoc()) {?>
        

        <div class="col-lg-5 col-md-6 col-sm-12">
            <img id="mainImg" class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image']; ?>" width="100%" class="small-img"/>
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image2']; ?>" width="100%" class="small-img"/>
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image3']; ?>" width="100%" class="small-img"/>
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img"/>
                </div>
            </div>
        </div>

        

        <div class="col-lg-6 col-md-12 col-12">
            <h6>Laptopuri</h6>
            <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
            <h2><?php echo $row['product_price']; ?> Lei</h2>
            <form method="POST" action="cos.php">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
            <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
            <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>

            <input type="number" name="product_quantity" value="1"/>
            <button class="buy-btn" type="submit" name="add_to_cart"> Adauga in cos</button>
            </form>
            <h4 class="mt-5 mb-5">Detalii produs</h4>
            <span><?php echo $row['product_description']; ?></span>
        </div>
        
        <?php } ?>
    </div>
</section>

<!-- Produsele similare-->
<section id="similare" class="w-100 py-5">
    <div class="container">
        <h3>Produse similare</h3>
        <div class="row justify-content-center">
            <!-- Unu -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="box">
                    <img class="img-fluid" src="assets/imgs/1.jpeg" alt="Product Image">
                    <div class="detalii">
                        <h2>TOP FAVORITE!</h2>
                        <p class="produsfavorit">Telefon SAMSUNG Galaxy S24 Ultra 5G</p>
                        <div class="star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="p-pret">4.499 Lei</h4>
                        <button class="btn btn-primary vezi-produsul">Vezi produsul</button>
                    </div>
                </div>
            </div>
            <!-- Doi -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="box">
                    <img class="img-fluid" src="assets/imgs/2.jpeg" alt="Product Image">
                    <div class="detalii">
                        <h2>TOP FAVORITE!</h2>
                        <p class="produsfavorit">Telefon APPLE iPhone 15 Pro 5G</p>
                        <div class="star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="p-pret">6.499 Lei</h4>
                        <button class="btn btn-primary vezi-produsul">Vezi produsul</button>
                    </div>
                </div>
            </div>
            <!-- Trei -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="box">
                    <img class="img-fluid" src="assets/imgs/3.jpeg" alt="Product Image">
                    <div class="detalii">
                        <h2>TOP FAVORITE!</h2>
                        <p class="produsfavorit">Laptop Gaming ASUS TUF Gaming A15</p>
                        <div class="star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="p-pret">4.999 Lei</h4>
                        <button class="btn btn-primary vezi-produsul">Vezi produsul</button>
                    </div>
                </div>
            </div>
            <!-- Patru -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="box">
                    <img class="img-fluid" src="assets/imgs/4.jpeg" alt="Product Image">
                    <div class="detalii">
                        <h2>TOP FAVORITE!</h2>
                        <p class="produsfavorit">Monitor Gaming LED IPS DELL G2422HS</p>
                        <div class="star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="p-pret">1.399 Lei</h4>
                        <button class="btn btn-primary vezi-produsul">Vezi produsul</button>
                    </div>
                </div>
            </div>
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
                        <li><a href="#">Termeni si conditii</a></li>
                        <li><a href="#">Politica de confidentialitate</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <h5 class="pb-2">Urmareste-ne</h5>
                    <div class="social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

    <script>
        var mainImg = document.getElementById("mainImg");
        var smallImgs = document.getElementsByClassName("small-img");

        for (var i = 0; i < smallImgs.length; i++) {
            smallImgs[i].onclick = function() {
                mainImg.src = this.src;
            }
        }
    </script>
</body>
</html>