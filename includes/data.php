<?php

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