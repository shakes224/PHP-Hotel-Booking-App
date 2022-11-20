<?php //this function is to create the hotels on the compare.php page
function newHotels($url) {
    $_SESSION['hotels'] = []; //superGLOBAL will be created and used when hotels are displayed
    $hotelInfo = json_decode(file_get_contents($url)); //the hotel data is stored in JSON within classes

    foreach ($hotelInfo as $data) {  //foreach loop that loops through the block of code and creates a new Hotel with the information
        $newHotel = new Hotel(
            $data->id,
            $data->name,
            $data->rate,
            $data->features,
            $data->location,
            $data->image,
        );
        array_push($_SESSION['hotels'], $newHotel); //inserts the elements mentioned above into one array
    }
} ?>