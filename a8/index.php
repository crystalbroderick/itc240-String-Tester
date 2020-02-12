<?php
//set default values
$name = '';
$email = '';
$phone = '';
$message = 'Enter some data and click on the Submit button.';

//process
$action = filter_input(INPUT_POST, 'action');

switch ($action) {
    case 'process_data':
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email');
        $phone = filter_input(INPUT_POST, 'phone');

        // trim the spaces from the start and end of all data
        $name = trim($name);
        $email = trim($email);
        $phone = trim($phone);

        // validate that name is not empty
        if(empty($name)){
            $message = "You must enter a name.";
        break;
        }

        // capitalize the first letters only of the name
        $name = ucwords($name);

        // get first from complete name  
        $i = strpos($name, ' ');
        if ($i === false) {
            $first_name = $name;
        } else {
            $first_name = substr($name, 0, $i);
            $last_name = substr($name, $i+1);
        }
        /* 
        //get middle and last name from complete name when applicable
        $nameparts = explode(" ", $name);

        if($nameparts >= 2) {
            $first_name = $nameparts[0];
            $middle_name = $nameparts[1];
            $last_name = $nameparts[2];
        } else if($nameparts <= 1){
            $first_name = substr($name, 0, $i);
            $last_name = substr($name, $i+1);
        }*/

        // validate email
        if (empty($email)) {
            $message = 'You must enter an email address.';
            break;
        } else if(strpos($email, '@') === false) {
            $message = 'The email address must contain an @ sign.';
            break;
        } else if(strpos($email, '.') === false) {
            $message = 'The email address must contain a dot character.';
            break;
        }

        // remove common formatting characters from the phone number
        $phone = str_replace('-', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);

        // validate the phone number
        if (strlen($phone) < 7) {
            $message = 'The phone number must contain at least seven digits.';
            break;
        }

        // format the phone number
        if (strlen($phone) == 7) {
            $part1 = substr($phone, 0, 3);
            $part2 = substr($phone, 3);
            $phone = $part1 . '-' . $part2;
        } else {
            $part1 = substr($phone, 0, 3);
            $part2 = substr($phone, 3, 3);
            $part3 = substr($phone, 6);
            $phone = $part1 . '-' . $part2 . '-' . $part3;
        }

        // format the message
        $message =
            "Hello $first_name,\n\n" .
            "Thank you for entering this data:\n\n" .
            "Name: $name\n" .
            "Email: $email\n" .
            "Phone: $phone\n" .
            "First Name: $first_name \n" .
            "Middle Name: $middle_name\n" .
            "Last Name: $last_name\n\n" .
            "Area Code: $part1\n" .
            "Phone Number: $part2-$part3";
        break;
}
include 'string_tester.php';

?>        