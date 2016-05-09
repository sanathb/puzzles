<?php
/*
 * @author Sanath Ballal
 * 
 */
define('MAX_PRICE', 250); //max price allowed

//Item names
$itemNames = array("Item 1", "Item 2", "Item 3", "Item 4", "Item 5");

//Price of items
$itemPrice = array("Item 1" => 10,
                   "Item 2" => 100,
                   "Item 3" => 30,
                   "Item 4" => 20,
                   "Item 5" => 250,
                  );

//Weight of items
$itemWeight = array("Item 1" => 200,
                    "Item 2" => 20,
                    "Item 3" => 300,
                    "Item 4" => 500,
                    "Item 5" => 250,
                   );


if(isset($_POST['items'])) {
    $items = $_POST['items'];
    
    //var to store parcel data
    global $packages;
    $packages = array();
        
    //sort the items by descending order of their weight
    $sortedItems = sortItemsByWeight($items);
    
    //get the sorted item names
    $items = array_keys($sortedItems);
    
    createNewPackage($items);
    
    echo "This order has following packages:";
    foreach($packages as $key => $val) {
        echo "<br><br> Package " . ($key + 1);
        echo "<br> Items - ";
        
        $noOfItems = count($packages[$key]);
        
        foreach($packages[$key] as $key2 => $package) {
            echo $package;
            if($noOfItems != ($key2+1) ) {
               echo ", ";
            }
        }
        
        $totalWeight = getTotalWeight($packages[$key]);
        
        echo "<br> Total weight - ". $totalWeight . "g";
        echo "<br> Total price - $". getTotalPrice($packages[$key]);
        echo "<br> Courier price - $". getCourierPrice($totalWeight) ;
    }
    
}


/*
 * To get the price of an item
 * @param $item
 */
function getItemPrice($item) {
    global $itemPrice;
    return $itemPrice[$item];
}

/*
 * To get weight of an item
 * @param $item
 */
function getItemWeight($item) {
    global $itemWeight;
    return $itemWeight[$item];
}

/*
 * To get total weight of items in the list
 * @param $items as an array
 */
function getTotalWeight($items) {
    $weight = 0;
    
    foreach($items as $item) {
        $weight += getItemWeight($item);
    }
    
    return $weight;
}

/*
 * To get total price of items in the list
 * @param $items as an array
 */
function getTotalPrice($items) {
    $price = 0;
    
    foreach($items as $item) {
        $price += getItemPrice($item);
    }
    
    return $price;
}

/*
 * Sort items by descending order of weight
 * 
 * @params $items array of items
 * @return sorted items in descending order and with key value pairs
 */
function sortItemsByWeight($items) {
    $itemsSortedWeightArray = array();
    
    foreach($items as $item) {
        $itemsSortedWeightArray[$item] = getItemWeight($item);
    }
    arsort($itemsSortedWeightArray);
    
    return $itemsSortedWeightArray;
}

/*
 * To create new parcel package
 * 
 * @param $items containing item names as an array
 * 
 * @return $packages array containing items names in package
 */
function createNewPackage($items) {
    
    global $packages;
    
    //get the first items weight and see which courier weight slot it falls into
    $packageSlot = checkPackageSlot(getItemWeight($items[0]));
        
    $packageArray[]  = $items[0];
    
    $remainingWeight = ($packageSlot) - (getItemWeight($items[0]));
    $remainingPrice = MAX_PRICE - getItemPrice($items[0]);
    
    unset($items[0]);
    
    //for the remaining items, if the weight fits in the remaining space and is within max price
    foreach($items as $key => $item) {
        
        if( $remainingWeight >= ($remainingWeight - (getItemWeight($item))) 
        && $remainingPrice >= (getItemPrice($item)) ) {
            $packageArray[]  = $item;
            
            $unsetKeys[] = $key; //don't unset within the loop
        }
    }
    
    $packages[] = $packageArray;
    
    //remove the items from the array that have been packed
    foreach($unsetKeys as $key) {
        unset($items[$key]);
    }
    
    $items = array_values($items); //set right the indexes in order
        
    if(empty($items)) {
        return $packages;
    }
    
    //recursively call this function until all items are packed
    createNewPackage($items);
}

/*
 * To check if a package falls under 
 * 0 - 200
 * 201 - 500
 * 501 - 1000
 * 1001 - 5000
 */
function checkPackageSlot($weight) {
    if($weight <= 200) {
        return 200;
    } elseif($weight <= 500) {
        return 500;
    } elseif($weight <= 1000) {
        return 1000;
    } elseif($weight <= 5000) {
        return 5000;
    }
}


/*
 * To get price for the weight of courier
 * @param $weight
 */
function getCourierPrice($weight) {
    if($weight <= 200) {
        return 5;
    } elseif($weight <= 500) {
        return 10;
    } elseif($weight <= 1000) {
        return 15;
    } elseif($weight <= 5000) {
        return 20;
    }
}

?>
<?php if(empty($_POST['items'])): ?>
<html>
<head></head>
    <body>
        <form  method="post">
            <?php foreach($itemNames as $itemName): ?>
                <?php echo $itemName;?><input type="checkbox" name="items[]" id="items" value="<?php echo $itemName;?>">
                <br>
            <?php endforeach; ?>
            <input type="submit" value="submit">
        </form>
    <body>
</html>
<?php endif; ?>
