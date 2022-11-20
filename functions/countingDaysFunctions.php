<?php 
function countDays($date1, $date2) {
    // Calculating the difference between the two dates that the user has selected for Check-in and Check-out
    $diff = strtotime($date2) - strtotime($date1);

    //abs: gives the absolute value of any number that has been given and always returns a positive number
    //round: rounding any floating number if it goes into the decimals
    //86400 seconds in a day
    return abs($diff / 86400);
}
?>