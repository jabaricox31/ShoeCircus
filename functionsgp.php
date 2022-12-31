<?php

function make_table1($rows){


    $count = 0;
    $vals = 0;

    //print_r($rows);
    echo "<tr>";
    while($vals != sizeof($rows)){
     
            echo '<td><a href="itemdesc.php?productName='.$rows[$vals]["productName"].'"><img src = "shoeimage/'.$rows[$vals]["productID"].'.png" alt="Shoe" style="width:200px;height:200px;"><p>'.$rows[$vals]["productName"].'</p></a></td>';

            $vals = $vals + 1;
            $count = $count + 1;

            if($count == 5)
            {
                echo "</tr>";
                echo "<tr>";

                $count = 0;
            }
        }
        echo "</tr>";




}

function make_table2($rows){

    echo "<table border=1 cellspacing=1>";

    foreach ($rows[0] as $key => $title){
        echo "<th>$key</th>";
    }
    
    foreach($rows as $row){
        echo "<tr>";
        foreach($row as $key => $thing){

            echo "<td>$thing</td>";
        }
        echo "</tr>";
    }

    echo "</table>";


}

function shopping_cart($rows)
{
    $price = 0;

    for( $count = 0; $count != sizeof($rows); $count++){
        $price += $rows[$count]["price"] * $rows[$count]["orderQTY"];
    echo'<form  method="POST" class="cart-items">
                    <div class="border rounded">
                        <div class="row bg-white">
                            <div class="col-md-3 pl-0">
                                <img src="shoeimage/'. $rows[$count]["productID"].'.png" alt="Item photo" class="cartphoto">
                            </div>
                            <div class="col-md-6">
                                <h5 class="pt-2">'.$rows[$count]["productName"].'</h5>
                                <small class="text-secondary">
                                <h5 class="pt-2">$'.$rows[$count]["price"].'</h5></small>
                                <button type="submit" class="btn btn-warning" name = "Update QTY">Update Quantity</button>
                                <button type="submit" class="btn btn-danger mx-2" name="remove">Remove</button>
                            </div>
                            <div class="col-md-3 py-5">
                                <div>';

                                echo'<label for="orderQTY">QTY:</label>
                                <select name="orderQTY" id="orderQTY">';
                                if ($rows[$count]["orderQTY"] == 1)
                                {
                                echo'<option value="1" selected>1</option>
                                <option value="2">2</option>';
                                }
                            
                                else if ($rows[$count]["orderQTY"] == 2)
                                {
                                echo'<option value="1">1</option>
                                <option value="2" selected>2</option>';
                                }

                                echo '<input type ="hidden" name = "productID" value ="'.$rows[$count]["productID"]. '">';
                                echo'</select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';

    }


    echo '<p class = "price" >Total Price of Items in Shopping Cart: $'. $price. '</p>';

}





?>