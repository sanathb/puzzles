<?php
/*
 * @author Sanath Ballal
 * 
 */
define('MAX_PRICE', 250); //max price allowed

//Item names
$itemNames = array("Item 1", "Item 2", "Item 3", "Item 4", "Item 5",
                   "Item 6", "Item 7", "Item 8", "Item 9", "Item 10",
                   "Item 11", "Item 12", "Item 13", "Item 14", "Item 15",
                   "Item 16", "Item 17", "Item 18", "Item 19", "Item 20",
                   "Item 21", "Item 22", "Item 23", "Item 24", "Item 25",
                   "Item 26", "Item 27", "Item 28", "Item 29", "Item 30",
                   "Item 31", "Item 32", "Item 33", "Item 34", "Item 35",
                   "Item 36", "Item 37", "Item 38", "Item 39", "Item 40",
                   "Item 41", "Item 42", "Item 43", "Item 44", "Item 45",
                   "Item 46", "Item 47", "Item 48", "Item 49", "Item 50",
                  );

//Price of items
$itemPrice = array("Item 1" => 10, "Item 2" => 100, "Item 3" => 30, "Item 4" => 20, "Item 5" => 30,
                    "Item 6" => 40, "Item 7" => 200, "Item 8" => 120, "Item 9" => 130, "Item 10" => 20,
                    "Item 11" => 10, "Item 12" => 4, "Item 13" => 5, "Item 14" => 240, "Item 15" => 123,
                    "Item 16" => 245, "Item 17" => 230, "Item 18" => 110, "Item 19" => 45, "Item 20" => 67,
                    "Item 21" => 88, "Item 12" => 10, "Item 23" => 17, "Item 24" => 19, "Item 25" => 89,
                    "Item 26" => 45, "Item 27" => 99, "Item 28" => 125, "Item 29" => 198, "Item 30" => 220,
                    "Item 31" => 249, "Item 32" => 230, "Item 33" => 190, "Item 34" => 45, "Item 35" => 12,
                    "Item 36" => 5, "Item 37" => 2, "Item 38" => 90, "Item 39" => 12, "Item 40" => 167,
                    "Item 41" => 12, "Item 42" => 8, "Item 43" => 2, "Item 44" => 9, "Item 45" => 210,
                    "Item 46" => 167, "Item 47" => 23, "Item 48" => 190, "Item 49" => 199, "Item 50" => 12,
                   );

//Weight of items
$itemWeight = array("Item 1" => 200, "Item 2" => 20, "Item 3" => 300, "Item 4" => 500, "Item 5" => 250,
                    "Item 6" => 10, "Item 7" => 10, "Item 8" => 500, "Item 9" => 790, "Item 10" => 100,
                    "Item 11" => 340, "Item 12" => 800, "Item 13" => 200, "Item 14" => 20, "Item 15" => 700,
                    "Item 16" => 10, "Item 17" => 20, "Item 18" => 200, "Item 19" => 200, "Item 20" => 20,
                    "Item 21" => 300, "Item 12" => 500, "Item 23" => 250, "Item 24" => 10, "Item 25" => 10,
                    "Item 26" => 500, "Item 27" => 790, "Item 28" => 100, "Item 29" => 340, "Item 30" => 800,
                    "Item 31" => 200, "Item 32" => 20, "Item 33" => 700, "Item 34" => 10, "Item 35" => 20,
                    "Item 36" => 200, "Item 37" => 200, "Item 38" => 20, "Item 39" => 300, "Item 40" => 500,
                    "Item 41" => 250, "Item 42" => 10, "Item 43" => 10, "Item 44" => 500, "Item 45" => 790,
                    "Item 46" => 100, "Item 47" => 340, "Item 48" => 800, "Item 49" => 200, "Item 50" => 20,
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
        
        if( ($remainingWeight >= (getItemWeight($item)) )
        && $remainingPrice >= (getItemPrice($item)) ) {
            $packageArray[]  = $item;
            
            $unsetKeys[] = $key; //don't unset within the loop
            
            $remainingWeight -= getItemWeight($item);
            $remainingPrice -= getItemPrice($item);
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
            <br>
            <input type="submit" value="submit">
        </form>
    <body>
</html>
<?php endif; ?>
