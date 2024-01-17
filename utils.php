<?php
function round_currency($value) {
    global $configuration_database;
    $currency = strtolower($configuration_database["currency"]);

    if ($currency == "usd" or $currency == "eur" or $currency == "cad") { $places = 2;
    } else if ($currency == "bch" or $currency == "xmr") { $places = 5;
    } else { $places = 8; };

    $multiply = 10**$places;

    return number_format(round($value*$multiply)/$multiply, 2);
}
?>
