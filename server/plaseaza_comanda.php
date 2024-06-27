<?php
session_start();
include('connection.php');

if(!isset($_SESSION['logat'])){
  header('location: ../checkout.php?message=Trebuie sa fi logat ca sa plasesezi o comanda!');
  //daca este logat
}else{
  if(isset($_POST['plaseaza_comanda'])){
    //preluarea si stocarea datelor utilizatorului
        $nume = $_POST['nume'];
        $email = $_POST['email'];
        $telefon = $_POST['telefon'];
        $oras = $_POST['oras'];
        $adresa = $_POST['adresa'];
        $order_cost = $_SESSION['total'];
        $order_status = "neplatita";
        $user_id = $_SESSION['user_id'];
        $order_date = date('Y-m-d H:i:s');

      $stmt = $conn->prepare("INSERT INTO orders (order_cost,order_status,user_id,user_phone,user_city,user_address,order_Date)
                                    VALUES (?,?,?,?,?,?,?); ");
      $stmt->bind_param('isiisss',$order_cost,$order_status,$user_id,$telefon,$oras,$adresa,$order_date);

      $stmt_status = $stmt->execute();

      if(!$stmt_status){
        header('location: index.php');
        exit;
      }
       //stocarea comenzii in baza de date
      $order_id = $stmt->insert_id;

      
    //preluarea produselor din cos 
      foreach($_SESSION['cos'] as $key => $value){

        $product = $_SESSION['cos'][$key];
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];
        //stocarea fiecarui produs in order_items db
        $stmt1 = $conn->prepare("INSERT INTO order_items (order_id,product_id,product_name,product_image,product_price,product_quantity,user_id,order_date)
                        VALUES (?,?,?,?,?,?,?,?)");

        $stmt1->bind_param('iissiiis',$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$user_id,$order_date);
        $stmt1->execute();
      }

   
    



    //golirea cosului -> dupa plata


    //informarea utilizatorului
    header('location: ../plata.php?order_status="comanda a fost plasata!"');
}
}



?>

