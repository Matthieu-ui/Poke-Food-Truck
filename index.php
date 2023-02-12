<?php

include('includes/header.php');

/*
Need to figure out
[X] how to append addons to item using html with php
[X] create cart class
[X] subtotal func
[X] tax func
[X] total func

new TO DOO
[x] display nothing cart if no items
[x] only display item that is purchased
[] Include addons to subtotal
[]... ***add more here***


*/

//Class Item
class Item
{
    public $ID = 0;
    public $name = '';
    public $description = '';
    public $price = 0;
    public $quantity = 0;
    public $addon = [];

    public function __construct($ID, $name, $description, $price)
    {
        $this->ID = $ID;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function setAddon($addon)
    {
        foreach ($addon as $item) {
            $this->addon[] = $item;
        }
    }

    public function setQuant($num)
    {
        $this->quantity = (int) $num;
    }
    public function getQuant()
    {
        return $this->quantity;
    }
}

//save new instance to variable
$items = new Item(
    0,
    'Spicy Ahi Bowl',
    'Spicy Ahi Tuna, Cucumber, Sweet Onion, Scallion, House Shoyu
Spicy Aioli, Masago ,Pickled Ginger',
    12.95
);
// $item->addon('Tuna');
// $item->addon('Rice');
// $item->addon('Onions');
$menuItems[] = $items;

$items = new Item(
    1,
    'Hawaiian Classic Bowl',
    'Ahi Tuna, Sweet Onion Hijiki (Seaweed), Scallion, House Shoyu Seaweed Salad, Sesame Seeds',
    13.95
);
$menuItems[] = $items;

$items = new Item(
    2,
    'Pike Place Bowl',
    'Salmon, Sweet Onion, Cucumber, Sesame Seeds, House Shoyu, Edamame, Crunchy Onion',
    14.95
);
$menuItems[] = $items;

//CART CLASS**
class Cart
{
    public $items = [];
    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function subtotal()
    {
        foreach ($this->items as $item) {
            $this->subtotal += $item->price * $item->quantity;
        }
    }

    public function tax()
    {
        $this->tax = $this->subtotal * 0.1;
    }

    public function total()
    {
        $this->total = $this->subtotal + $this->tax;
    }
}

//end cart class
?>

    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="card-container">
        <?php //grabs $menuItem array -> sets item
        foreach ($menuItems as $key => $item) { ?>
        <div class="card">
            <h2><?= $item->name ?></h2>
            <p><?= $item->description ?></p>
            <label>Quantity</label>
            <select name="quantity-<?= $key ?>">
                <option value="">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <div class="addon">
                <input type="checkbox" name="addon-<?= $key ?>[]" value="tuna">
                <label for="addon">Add Tuna</label>
                <input type="checkbox" name="addon-<?= $key ?>[]" value="rice">
                <label for="addon">Add Rice</label>
                <input type="checkbox" name="addon-<?= $key ?>[]" value="onion">
                <label for="addon">Add Onions</label>
            </div>     
        </div>
        
        <?php }
// -Used itemID to generate new post key with quantity-ItemID.
?>
    
    </div>
    <button type="submit">Submit</button>
    <button type="reset" onClick="window.location.href='<?= $_SERVER[
        'PHP_SELF'
    ] ?>'" >Reset</button>
    </form>


<br/>
<br/>
<br/>
<!-- **start cart html** -->
<div class="cart">
    <h2>Cart</h2>
    <div class="cart-items">
        <div class="cart-item">


<?php
// PHP for displaying cart items

//if post request***
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //loop through menu items***
    for ($index = 0; $index < count($menuItems); $index++) {
        //if quantity is set***
        if (isset($_POST['quantity-' . $index])&& $_POST['quantity-' . $index] !=='') {
            //set quantity***
            $menuItems[$index]->setQuant($_POST['quantity-' . $index]);
            //if addon is set***
            if (isset($_POST['addon-' . $index])) {
                //set addon***
                $menuItems[$index]->setAddon($_POST['addon-' . $index]);
            }

            //display cart items***
            echo '<p>Line 189:' .
                $menuItems[$index]->name .
                ' ($' .
                $menuItems[$index]->price .
                ')' .
                ' x ' .
                $menuItems[$index]->quantity .
                '</p>';

            //display addon items***
            if (isset($_POST['addon-' . $index])) {
                foreach ($_POST['addon-' . $index] as $addon) {
                    echo '<p>' . $addon . '($1.00)' . '</p>';
                }
            }
        }
    }
}

echo '<br>';
echo '<br>';

// create new cart***
// add subtotal, tax, total***
$cart = new Cart($menuItems);
$cart->subtotal();
$cart->tax();
$cart->total();

echo '<br>';
// display cart total and tax***
echo '<p>Subtotal: $' . ($cart->subtotal = round($cart->subtotal, 2) . '</p>');
echo '<p>Tax: $' . ($cart->tax = round($cart->tax, 2) . '</p>');
echo 'Total: $' . ($cart->total = round($cart->total, 2) . '</p>');
echo '<br>';
echo '<br>';
echo '<br>';
?>

</div>
</div>
</div>


<!-- ***end cart HTML*** -->


    <?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     //if post item is set
//     for ($index=0; $index < count($menuItems); $index++) {
//         if (!empty($_POST["quantity-{$index}"])) {
//             //sets quantity to item object thru method
//             $menuItems["{$index}"]->setQuant($_POST["quantity-{$index}"]);
//             //adds addon to item object tru method
//             if (!empty($_POST["addon-{$index}"])) {
//                 $menuItems["{$index}"]->addon($_POST["addon-{$index}"]);
//             }
//         } else {
//             $_POST["quantity-{$index}"] = null;
//         }
//     }
//     echo '<pre>';
//     echo var_dump($_POST);
//     echo '</pre>';
// }
?>

</body>
</html>