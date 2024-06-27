<?php 
session_start();
include('server/connection.php');

if(!isset($_SESSION['logat'])){
    header('location: login.php');
    exit;
}

if(isset($_GET['delogare'])){
    if(isset($_SESSION['logat'])){
        unset($_SESSION['logat']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
    }
}

if(isset($_POST['schimba_parola'])){

        $parola = $_POST['parola'];
        $confirma_parola = $_POST['confirmaParola'];
        $email_utilizator = $_SESSION['user_email'];

        if($parola !== $confirma_parola){
            header('location: cont.php?error=Parolele nu se potrivesc');
        }
        
        else if(strlen($parola) < 6){
            header('location: inregistrare.php?error=Parola nu poate sa aiba mai putin de 6 cifre!');
        
        }else{
           $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
           $stmt->bind_param('ss',md5($parola),$email_utilizator);
           if($stmt->execute()){
            header('location: cont.php?message=Parola a fost schimbata');
           }else{
            header('location: cont.php?error=Parola nu a putut fi schimbata');
           }

        }
}

//comenzi
if(isset($_SESSION['logat'])){
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=?");

    $stmt->bind_param('i',$user_id);

    $stmt->execute();

    $comenzi = $stmt->get_result();
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cont</title>
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

      <!-- Cont -->
      <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <p class="text-center" style="color:green"><?php if(isset($_GET['inregistrare_succes'])){echo $_GET['inregistrare_succes'];}?></p>
            <p class="text-center" style="color:green"><?php if(isset($_GET['login_succes'])){echo $_GET['login_succes'];}?></p>
                <h3 class="font-weight-bold">Informatii cont</h3>
                <hr class="mx-auto">
                <div class="account-info">
                    <p>Nume: <span><?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}?></span></p>
                    <p>Email: <span><?php if(isset($_SESSION['user_email'])){echo $_SESSION['user_email'];}?></span></p>
                    <p><a href="#comenzi" id="orders-btn">Comenzile tale</a></p>
                    <p><a href="cont.php?delogare=1" id="logout-btn">Delogheaza-te</a></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
                <form id="account-form" method="POST" action="cont.php">
                    <p class="text-center" style="color:red"><?php if(isset($_GET['error'])){echo $_GET['error'];}?></p>
                    <p class="text-center" style="color:green"><?php if(isset($_GET['message'])){echo $_GET['message'];}?></p>
                    <h3>Schimba parola</h3>
                    <hr class="mx-auto">
                    <div class="form-group"> 
                        <label>Parola</label>
                        <input type="password" class="form-control" id="account-password" name="parola" placeholder="Parola" required>
                    </div>
                    <div class="form-group"> 
                        <label>Confirma Parola</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmaParola" placeholder="Confirmare Parola" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Schimba Parola" name="schimba_parola" class="btn" id="change-pass-btn">
                    </div>
                </form>
            </div>
        </div>
      </section>

      <!-- Comenzi -->
      <section class="orders container my-5 py-5">
        <div class="container mt-2">
            <h2 class="font-weight-bold text-center">Comenzile tale</h2>
            <hr class="mx-auto">
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Nr. comanda</th>
                <th>Valoare comanda</th>
                <th>Status comanda</th>
                <th>Data comanda</th>
                <th>Detalii comanda</th>
            </tr>

            <?php while($row = $comenzi->fetch_assoc()){?>

            <tr>
                <td>
                    <span><?php echo $row['order_id'];?></span>
                </td>
                <td>
                    <span><?php echo $row['order_cost'];?> Lei</span>
                </td>
                <td><span><?php echo $row['order_status'];?></span></td>
                <td>
                <span><?php echo $row['order_date'];?></span>
                </td>
                <td>
                    <form method="POST" action="detalii_comanda.php">
                        <input type="hidden" value="<?php echo $row['order_status'];?>" name="order_status"/>
                        <input type="hidden" value="<?php echo $row['order_id'];?>" name="order_id"/>
                        <input class="btn detalii-comanda-btn" name="detalii_comanda_btn" type="submit" value="detalii"/>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </table>


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