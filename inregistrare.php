<?php 
    session_start();
    include('server/connection.php');

    //daca este deja logat
    if(isset($_SESSION['logat'])){
        header('location: cont.php');
        exit;
    }

if(isset($_POST['inregistrare'])){

    $nume = $_POST['nume'];
    $email = $_POST['email'];
    $parola = $_POST['parola'];
    $confirmaparola = $_POST['confirmaParola'];

    
    if($parola !== $confirmaparola){
        header('location: inregistrare.php?error=Parolele nu sunt identice');
    }
    
    else if(strlen($parola) < 6){
        header('location: inregistrare.php?error=Parola nu poate sa aiba mai putin de 6 cifre!');
    }//daca nu este vreo eroare
    else{
        //verifica daca exista un user cu acelasi email
        $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
        $stmt1->bind_param('s',$email);
        $stmt1->execute();
        $stmt1->bind_result($num_rows);
        $stmt1->store_result();
        $stmt1->fetch();
    

     if ($num_rows != 0){
        header('location: inregistrare.php?error=Deja exista un utilizator cu acest email!');
    }else{
        //creeaza user
        $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password)
                VALUES (?,?,?)");
        $stmt->bind_param('sss',$nume,$email,md5($parola));

        if($stmt->execute()){
            $user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $nume;
            $_SESSION['logat'] = true;
            header('location: cont.php?inregistrare_succes=Te-ai inregistrat cu succes!');
        }else{
            header('location: inregistrare.php?error=Nu s-a putut crea contul');
            }
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inregistrare</title>
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

      <!-- Inregistrare -->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Inregistrare</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container"></div>
            <form id="register-form" method="POST" action="inregistrare.php">
                <p style="color: red;"><?php if(isset($_GET['error'])){echo $_GET['error'];}?></p>
                <div class="form-group">
                    <label>Nume</label>
                    <input type="text" class="form-control" id="register-name" name="nume" placeholder="Nume" required/>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required/>
                </div>
                <div class="form-group">
                    <label>Parola</label>
                    <input type="password" class="form-control" id="register-password" name="parola" placeholder="Parola" required/>
                </div>
                <div class="form-group">
                    <label>Confirmare Parola</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmaParola" placeholder="Confirmare Parola" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="inregistrare" value="Inregistreaza-te"/>
                </div>
                <div class="form-group">
                    <a id="login-url" href="login.php" class="btn">Ai deja un cont? Logheaza-te</a>
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