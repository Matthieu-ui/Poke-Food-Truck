<?php

include 'includes/header.php';

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
?>
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
    <div class="mt-8 bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
        <h1 class="text-2xl text-blue-500">POKE TRUCK</h1>
        <?php foreach ($menuItems as $key => $item) { ?>
        <div class="my-8">
            <div class="flex justify-between">
            <h2 class="text-lg text-pink-500"><?= $item->name ?></h2>
            <div>
                <label class="">Quantity</label>
                <!-- check if selected -->
                <select name="quantity-<?= $key ?>">
                    <option value="0" <?php if (
                        isset($_POST['quantity-' . $key]) &&
                        $_POST['quantity-' . $key] == 0
                    ) {
                        echo 'selected="selected"';
                    } ?>>0</option>
                    <option value="1" <?php if (
                        isset($_POST['quantity-' . $key]) &&
                        $_POST['quantity-' . $key] == 1
                    ) {
                        echo 'selected="selected"';
                    } ?>>1</option>
                    <option value="2" <?php if (
                        isset($_POST['quantity-' . $key]) &&
                        $_POST['quantity-' . $key] == 2
                    ) {
                        echo 'selected="selected"';
                    } ?>>2</option>
                    <option value="3" <?php if (
                        isset($_POST['quantity-' . $key]) &&
                        $_POST['quantity-' . $key] == 3
                    ) {
                        echo 'selected="selected"';
                    } ?>>3</option>
                    <option value="4" <?php if (
                        isset($_POST['quantity-' . $key]) &&
                        $_POST['quantity-' . $key] == 4
                    ) {
                        echo 'selected="selected"';
                    } ?>>4</option>
                    <option value="5" <?php if (
                        isset($_POST['quantity-' . $key]) &&
                        $_POST['quantity-' . $key] == 5
                    ) {
                        echo 'selected="selected"';
                    } ?>>5</option>

                </select>
            </div>
            </div>
                <p class="my-2 text-zinc-700"><?= $item->description ?></p>
            

            
                <!-- check if checked -->
                <div class="flex justify-between">

                
                <label for="addon">Add-Ons:</label>
                <div class="w-5/6 flex justify-around">
                
                <div>
                <input type="checkbox" name="addon-<?= $key ?>[]" value="tuna" <?php if (
    isset($_POST['addon-' . $key]) &&
    in_array('tuna', $_POST['addon-' . $key])
) {
    echo 'checked="checked"';
} ?>>
                <label for="addon">Add Tuna</label>
                </div>

                <div>
                <input type="checkbox" name="addon-<?= $key ?>[]" value="rice"<?php if (
    isset($_POST['addon-' . $key]) &&
    in_array('rice', $_POST['addon-' . $key])
) {
    echo 'checked="checked"';
} ?>>
                <label for="addon">Add Rice</label>
                </div>

                <div>
                <input type="checkbox" name="addon-<?= $key ?>[]" value="onion" <?php if (
    isset($_POST['addon-' . $key]) &&
    in_array('onion', $_POST['addon-' . $key])
) {
    echo 'checked="checked"';
} ?>>
                <label for="addon">Add Onions</label>
                </div>
                </div>
            </div>     
        </div>


        <?php } ?>
        <button class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded" type="submit">Submit</button>
    <!-- php self reset -->
    <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="reset"  onClick="window.location.href='<?php echo $_SERVER[
        'PHP_SELF'
    ]; ?>'" value="Reset">Reset</button>
    </div>
    
        <br>
    </form>
    <?php
    //if post request***

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //loop through menu items
        foreach ($menuItems as $key => $item) {
            //if quantity is not empty
            if (!empty($_POST['quantity-' . $key])) {
                //set quantity
                $item->setQuant($_POST['quantity-' . $key]);
                //set addon if not empty
                if (!empty($_POST['addon-' . $key])) {
                    $item->setAddon($_POST['addon-' . $key]);
                }
                //add to cart
                $cart[] = $item;
            }
        } //end foreach
    }

    class Cart
    {
        public $items = [];
        public $addons = [];
        public $subtotal = 0;
        public $tax = 0;
        public $total = 0;

        public function __construct($items)
        {
            $this->items = $items;
        }
        public function setAddon($addon)
        {
            $this->addons = $addon;
        }

        public function subtotal()
        {
            foreach ($this->items as $item) {
                $this->subtotal +=
                    $item->price * $item->quantity + count($item->addon) * 1.5;
            }
            return number_format($this->subtotal, 2);
        }

        public function tax()
        {
            $this->tax = $this->subtotal * 0.1;
            return number_format($this->tax, 2);
        }

        public function total()
        {
            $this->total = $this->subtotal + $this->tax;
            return number_format($this->total, 2);
        }

        public function displayCart()
        {
            // addons is array
            foreach ($this->items as $item) {
            echo $item->quantity . ' ';
            echo $item->name . ' $' . $item->price . '';
            echo ' <br/> Add Ons: ';
            // implode array (array to string) and add $1.50 to each
            echo implode(', ', $item->addon) . ' $' . number_format(count($item->addon) * 1.50, 2) ;
            // if no addon
            if (empty($item->addon)) {
                echo ' None';
            }

            echo '<br>';
            }
        }

        public function displaySubtotal()
        {
             $this->subtotal();
        }
    }

    //if cart is not empty display cart
  if (!empty($cart)) {
    $cart = new Cart($cart);
    echo '<div class="mt-8 bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">';
    echo '<h2 class="">Cart</h2>';
    $cart->displayCart();
    echo '<br>';
    echo 'Subtotal: $'. $cart->subtotal();
    echo '<br>';
    echo 'Tax: $';
    echo $cart->tax();
    echo '<br>';
    echo 'Total: $';
    echo $cart->total();
    echo '</div>';
} else {
    echo '<div class="mt-8 bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">Your cart is empty!</div>';
}
?>

</body>
</html>



