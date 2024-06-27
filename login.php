<?php
session_start();
include('server/connection.php');


if(isset($_SESSION['logat'])){
    header('location: cont.php');
    exit;
}

if(isset($_POST['login_btn'])){
    $email = $_POST['email'];
    $parola = md5($_POST['parola']);

    $stmt = $conn->prepare("SELECT user_id,user_name,user_email,user_password FROM users WHERE user_email=? AND user_password =? LIMIT 1");
    $stmt->bind_param('ss',$email,$parola);
    
    if($stmt->execute()){
        $stmt->bind_result($user_id,$user_name,$user_email,$user_password);
        $stmt->store_result();

        if($stmt->num_rows() == 1){
            $row = $stmt->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['logat'] = true;

            header('location: cont.php?login_succes=Te-ai logat cu succes!');
        }else{
            header('location: login.php?error=Nu s-a gasit niciun cont cu aceste date!');
        }
    }else{
        //eroare
        header('location: login.php?error=S-a produs o eroare');
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

      <!-- login -->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" method="POST" action="login.php">
              <p style="color:red" class="text-center"><?php if(isset($_GET['error'])){echo $_GET['error'];}?></p>
              <p class="text-center" style="color:green"><?php if(isset($_GET['message'])){echo $_GET['message'];}?></p>
              <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required/>
                </div>
                <div class="form-group">
                    <label>Parola</label>
                    <input type="password" class="form-control" id="login-password" name="parola" placeholder="Parola" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
                </div>
                <div class="form-group">
                    <a id="inregistrare-url" href="inregistrare.php" class="btn">Nu ai cont? Inregistreaza-te</a>
                </div>
        </div>
            </form>
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