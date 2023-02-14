<?php

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
?>