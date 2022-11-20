<?php
    ini_set('display_errors', 1); //ini_set allows the developer to modify settings within PHP
    ini_set('display_startup_errors', 1); //the parameters take in: 1st is the name of the setting, second one is the new value assigned to it
    error_reporting(E_ALL);  //shows error messages because it is more readable and understandable

    //require takes all the files mentioned below and allows us to use it in this current file
    require "functions/countingDaysFunctions.php"; 
    require "functions/hotelFunction.php";
    require "classes/customer.php";
    require "classes/hotels.php";
    require "classes/bookingClass.php";

    session_start(); //creates a session or resumes a session based on a POST or GET request

    $hotelChoice; //calling the variable $hotelChoice;

    //checks for the variable 'book-hotel', creates a super global 'book-hotel' that can be used across all pages
    if(isset($_POST['book-hotel'])) { 
        try {  //try contains the code that might throw some errors, the code will be executed until or if a eroor/exception is thrown out
            newHotels("hotels/hotelInfo.json");
        } catch (Exception $err) {
            echo "<script> console.log('Server error when loading hotels..' + $err) </script>"; //displays the error message if the 'try' doesn't work
        }
        //foreach loop that creates a session called 'hotels' as $hotel and if the $hotel getName is equil to the superglobal 'choice', then hotelChoice is equal to $hotel 
        foreach ($_SESSION['hotels'] as $hotel) { 
            if ($hotel->getName() == $_POST['choice']){
                $hotelChoice = $hotel;
            }
        }

        try{ //$booking variable creates a new booking, with $_SESSIONS for checkin, checkout, numberOfDays, cost and getName to be shown on the 
            //booking.php page for the user to verify that they are happy with their choice
            $booking = new Booking(
                $_SESSION['checkin'],
                $_SESSION['checkout'],
                $_SESSION['numberOfDays'],
                $_POST['cost'],
                $hotelChoice->getName()
            );
        } catch (Exception $err){ //if the new Booking has an error this exception will help display the error until I fix it (which happened more then once, so I approve this error work)
            echo "<script> console.log('Server error while creating the booking.' + $err)</script>"; 
        }
    }
?>

<!DOCTYPE html> <!-- HTML tag -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Summary</title>
    <link rel="stylesheet" href="css/booking.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="information">
        <h1>Last final step we are almost done! <?php echo $_SESSION['user']->getName() ?>...</h1>
        <!-- Created a session with user that gets the username and displayes it for some personalization  -->
        <p>We're about to send all the following information to the hotel you've chosen</p>
        <p>Please make sure that all your information is correct</p>
        <form method="post" name="sendEmail" action="email.php">
            <div class="personal-information">
                <h2>Personal Information</h2>
                <!-- The following php tag holds the information for the hotel the client has chosen. It will display name, email address, hotel, daily rate, duration of stay, arriving on, leaving on and the total stay amount.
                Then there are two buttons,
                1. Send to hotel of choice: This will send an email to the hotel for processing and booking information
                2. Sign out: sign out and go back to the first page where you could reset every-->
                <?php
        echo '
        <ul> Name: '.$_SESSION['user']->getName().' '.$_SESSION['user']->getLastName().'</ul>
        <ul> Email Address: '.$_SESSION['user']->getEmail().'</ul>';
        ?>
            </div>
            <div class="hotel-of-choice">
                <h2>Hotel Information</h2>
                <?php
        echo '
        <ul> Hotel: '.$hotelChoice->getName().'</ul>
        <ul> Daily Rate: R '.$hotelChoice->getRate().',00 </ul>';
        ?>
            </div>
            <div class="booking-information">
                <h2>Booking Information</h2>
                <?php echo '
        <ul> Duration of Stay: '.$booking->getDuration().'</ul>
        <ul> Arriving on: '.$booking->getCheckInDate().'</ul>
        <ul> Leaving on: '.$booking->getCheckOutDate().'</ul>
        ' ?>
            </div>
            <div class="total">
                <?php echo'
        <ul> Total for your entire stay in your Hotel of choice: R '.$booking->getPricing().',00 </ul>
        '; ?>
            </div>
            <input class="submit" type="submit" value="Send to Hotel of Choice">
            <button class="log-out">
                <a style="text-decoration: none; color: white;" href="index.php">Sign Out</a>
            </button>
        </form>
    </div>
</body>

</html>