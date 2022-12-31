<?php
declare(strict_types = 1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoecirus.com</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" integrity="sha512-rqQltXRuHxtPWhktpAZxLHUVJ3Eombn3hvk9PHjV/N5DMUYnzKPC1i3ub0mEXgFzsaZNeJcoE0YHq0j/GFsdGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
* {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: "Audiowide", sans-serif;
}

.header {
  overflow: hidden;
  background-color: #1E90FF;
  padding: 10px 10px;
  width: 100%;
  box-shadow: 10px 10px 5px lightblue;
  
}

p {
  margin-top: 30px;
}

input[type=text], select, input[type=submit], .checkout {
        width: 95%;
        padding: 12px 20px;
        margin: 8px 0;
        margin-left: 2%;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    .checkout{
      margin-bottom: 2%;
        color: white;
        background-color: dodgerblue;
    }

.header a {
  float: center;
  color: white;
  text-align: center;
  padding: 12px;
  text-decoration: none;


  border-radius: 4px;
}

.price{
  font-size: 30px;
}
.footer{
  background-color: black;
  color: white;
  width:100%;
  padding: 10px 10px;
  text-align: center;
  font-family: Arial, Helvetica, sans-serif;
}


.icon{
  width: 50px;
  height: 50px;
  float: left;
}

h2{
  font-family: "Audiowide", sans-serif;
}

h3{
  text-align:center;
  font-size: 50px;
  margin-top: 3%;
  margin-bottom: 3%;
  font-family: "Audiowide", sans-serif;
}

.icon-right{
  width: 50px;
  height: 50px;
  float: right;
  margin-right: 10px;
  
}


.dart {
    display:block; 
    text-align: center;

    margin-left: auto;
    margin-right: auto; 
    width: 100px;
    height:100px;
    border-radius:50%;

}

.table{
  margin-left: auto;
  margin-right: auto;
  border: 10px dodgerblue;
  border-style: groove;
  padding-bottom: 5px;
  padding-top: 10px;
  padding-left: 10px;
  padding-right: 10px;
  margin-bottom: 10px;
}



.header a.active {
  background-color: dodgerblue;
  color: black;
}


/*@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: center;
  }
*/


</style>




</head>
<body>

<div class="header">
  <a href="customermain.php" class="logo"><img class = "dart" src ="shoeimage/CompanyLogo.png" alt = "Company Logo" ></a>
  <a class="active" href="customermain.php"><img class = "icon" src ="shoeimage/Home.png" alt = "Home Page" ></a>
  <a href = "GroupProjectlogin.html"><img class = "icon-right" src = "shoeimage/Logout.png" alt = "Logout"></a>
    <a href="order_tracker.php"><img class = "icon-right" src ="shoeimage/OrderTracker.png" alt = "Orders" ></a>
    <a href="shoppingcart2.php"><img class = "icon-right" src ="shoeimage/ShoppingCart.png" alt = "Shopping Cart" ></a>
  </div>
</div>


    <?php
include ('secrets.php');
include ("functionsgp.php");
session_start();

echo '<h3>Your Shopping Cart</h3>';
try { 
    $dsn = "mysql:host=courses;dbname=".$username;
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
    catch(PDOexception $e) { 
    echo "Connection to database failed: " . $e->getMessage();
    }
$rs = $pdo->prepare("SELECT * FROM INVENTORY, SHOPPING_CART WHERE userName = ? AND INVENTORY.productID = SHOPPING_CART.productID");
$rs->execute(array($_SESSION["username"]));
$rows= $rs-> fetchAll(PDO::FETCH_ASSOC);



if (sizeof($rows) == 0)
{
  echo 'Your shopping cart is empty :(. <a href ="customermain.php">Click here to change that!</a>';
}


else{
  shopping_cart($rows);


echo '<br><a href = "checkout.php"><button class = "checkout">Proceed to Checkout</button></a>';
}
if($_POST)

{
if (isset($_POST["remove"]))
{
    $rs = $pdo->prepare("DELETE FROM SHOPPING_CART WHERE userName = ? AND productID = ? ");
    $rs->execute (array($_SESSION["username"], $_POST["productID"]));
    echo "<meta http-equiv='refresh' content='0'>";

}

else
{
    try{
    $rs = $pdo->prepare("UPDATE SHOPPING_CART SET orderQTY = ? WHERE userName = ? and productID = ? ");
    $rs->execute (array($_POST["orderQTY"],$_SESSION["username"], $_POST["productID"]));
    echo "<meta http-equiv='refresh' content='0'>";
    }

    catch(PDOexception $e) { 
        echo "Update failed: " . $e->getMessage();
        die();
    }


}
}



?>

<div class = "footer">
  <p>Shoe Circus is a project made by Dominic Brooks, Jacob Diep, Jabari Cox, Dhruvit Patel, and Logan Misevich</p>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
