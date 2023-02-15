<?php
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

?>