<?php
include_once 'menu.php';
error_reporting(0);

// Instantiate Menu object
$menu = new Menu($text, $sessionId);

// Extract POST data
$sessionId = $_POST['sessionId'];
$phoneNumber = $_POST['phoneNumber'];
$serviceCode = $_POST['serviceCode'];
$text = $_POST['text'];
$userCheck=$menu->isRegistered($phoneNumber);

if($userCheck['status']=="success"){
    $status=true;
}else{
    $status=false;
}
// Assume user is registered for now
$isRegistered = $status;


// Process USSD input
if($text == "" && !$isRegistered){
    //Do something
    $menu -> mainMenuUnregistered();
}
else if($text == "" && $isRegistered){
    //Do something
    $menu -> mainMenuRegistered();
 
}
else if(!$isRegistered){
    //Do something
    $textArray = explode("*", $text);
    switch($textArray[0]){
        case 1:
            $menu->menuRegister($textArray,$phoneNumber);
            break;
        default:
            echo "END Invalid option, retry";
    }
}
else {
    // Extract option from user input
    $textArray = explode("*", $text);
    $option = $textArray[0];

    // Perform action based on selected option
    switch ($option) {
        case 1:
            // Display menu items
            $menu->bookMenuItems($textArray,$phoneNumber);
            break;
        case 2:
            // Book a table
            $menu->bookMenuItems($textArray,$phoneNumber);
            break;
        case 3:
            // View order status
            $menu->viewOrderStatus($textArray,$phoneNumber);
            break;
        case 4:
            // Provide catering information
            $menu->DeleteFood($textArray,$phoneNumber);
            break;
        case 5:
            // Prompt for account creation details
            $menu->updateFood($textArray,$phoneNumber);
            break;
        case 6:
            // Prompt for login credentials
            $menu->login();
            break;
        default:
            // Invalid option
            echo "END Invalid choice\n";
            break;
    }
}
?>
