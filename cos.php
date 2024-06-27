<?php 

session_start();

if(isset($_POST['add_to_cart'])){

    //daca user-ul deja a adaugat un prodsu in cos
    if(isset($_SESSION['cos'])){
        $product_array_ids = array_column($_SESSION['cos'],"product_id");
        //verifica daca produsul a fost adaugat deja
        if(!in_array($_POST['product_id'], $product_array_ids)){

            $product_id = $_POST['product_id'];
            
            $product_array = array(
                            'product_id' => $_POST['product_id'],
                            'product_name' => $_POST['product_name'],
                            'product_price' => $_POST['product_price'],
                            'product_image' => $_POST['product_image'],
                            'product_quantity' => isset($_POST['product_quantity']) ? $_POST['product_quantity'] : 1 // Default to 1 if not set
                );

                $_SESSION['cos'][$product_id] = $product_array;
            //produsul a fost adaugat deja
        }else{
            echo '<script>alert("Produsul este deja in cos!");</script>';
        }


        //daca e primul produs
    }else{
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = isset($_POST['product_quantity']) ? $_POST['product_quantity'] : 1;

        $product_array = array(
                        'product_id' => $product_id,
                        'product_name' => $product_name,
                        'product_price' => $product_price,
                        'product_image' => $product_image,
                        'product_quantity' => $product_quantity
        );

        $_SESSION['cos'][$product_id] = $product_array;

    }

//stergere produs din cos
}else if(isset($_POST['remove_product'])){
    
    $product_id = $_POST['product_id'];
    unset($_SESSION['cos'][$product_id]);

} else if (isset($_POST['edit_quantity'])) {

    $product_id = $_POST['product_id'];
    
    // Ensure product_quantity is set before using it
    if (isset($_POST['product_quantity'])) {
        $product_quantity = $_POST['product_quantity'];

        $product_array = $_SESSION['cos'][$product_id];
        $product_array['product_quantity'] = $product_quantity;
        
        $_SESSION['cos'][$product_id] = $product_array;
    } else {
        echo '<script>alert("Cantitatea produsului nu este setată.");</script>';
    }

             
    }else{
        header('location: index.php');
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cos</title>
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
                          <a class="nav-link dropdown-toggle" href="#" id="produseDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Produse
                          </a>
                          <div class="dropdown-menu" aria-labelledby="produseDropdown">
                            <a class="dropdown-item" href="telefoane.html">Telefoane</a>
                            <a class="dropdown-item" href="laptopuri.html">Laptopuri</a>
                            <a class="dropdown-item" href="monitoare.html">Monitoare</a>
                          </div>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">Suport Clienti</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">Magazine</a>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>

      <!-- Cos -->
       <section class="cos container my-5 py-5">
            <div class="container mt-5">
                <h2 class="font-weight-bold">Cosul tau</h2>
                <hr>
            </div>

            <table class="mt-5 pt-5">
                <tr>
                    <th>Produs</th>
                    <th>Cantitate</th>
                    <th>Subtotal</th>
                </tr>
            <?php foreach($_SESSION['cos'] as $key => $value) { ?>

                <tr>
                    <td>
                        <div class="info-produs">
                            <img src="assets/imgs/<?php echo $value['product_image'];?>"/>
                            <div>
                                <p><?php echo $value['product_name'];?></p>
                                <small><?php echo $value['product_price'];?><span> Lei</span></small>
                                <br>
                                <form method="POST" action="cos.php">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                                    <input type="submit" name="remove_product" class="remove-btn" value="Sterge produs"/>
                                </form>
                                
                            </div>
                        </div>
                    </td>

                    <td>
                        
                        <form method="POST" action="cos.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                            <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>"/>
                            <input type="submit" class="edit-btn" value="edit" name="edit_quantity"/>
                        </form>
                        
                    </td>

                    <td>
                        <span>lei</span>
                        <span class="pret-produs">2000</span>
                    </td>
                </tr>
                <?php } ?>
            </table>

           <div class="cos-total">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>lei 2000</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>lei 2000</td>
                </tr>
            </table>
           </div>

           <div class="checkout-container"> 
                <button class="btn checkout-btn">Checkout</button>
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
</body>
</html>