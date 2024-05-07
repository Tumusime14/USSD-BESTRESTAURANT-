<?php

// Include the database connection
include("connect.php");

// Define the Menu class
class Menu {
    private $text;
    private $sessionId;
    private $pdo;
    // Constructor
    public function __construct($text, $sessionId) {
        $this->text = $text;
        $this->sessionId = $sessionId;
        $this->pdo = $GLOBALS['conn'];
    }

    // Method to check if a user is registered based on their phone number
    public function isRegistered($phoneNumber) {    
        // Prepare and execute the query to find the user by phone number
        $stmt =$this->pdo->prepare("SELECT * FROM `users` WHERE `phone` = :phoneNumber");
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->execute();
        
        // Check the number of rows returned
        if ($stmt->rowCount() > 0) {
            // If a user is found, fetch the user data
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'status' => 'success',
                'data' => $userData
            ];
        } else {
            // If no user is found, return an error status message
            return [
                'status' => 'error',
                'message' => 'User not found',
                'data' => null
            ];
        }
    }

    public function passwordVerify($phoneNumber,$pin) {
    
        // Prepare and execute the query to find the user by phone number
        $stmt =$this->pdo->prepare("SELECT * FROM `users` WHERE `phone` = :phoneNumber and password='$pin'");
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->execute();
        
        // Check the number of rows returned
        if ($stmt->rowCount() > 0) {
            // If a user is found, fetch the user data
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'status' => 'success',
                'data' => $userData
            ];
        } else {
            // If no user is found, return an error status message
            return [
                'status' => 'error',
                'message' => 'User not found',
                'data' => null
            ];
        }
    }
    

    // Method to display the main menu for unregistered users
    public function mainMenuUnregistered() {
        echo "CON Main Menu for Unregistered Users:\n";
        echo "1.Register\n";
        
    }

    // Method to display the main menu for registered users
    public function mainMenuRegistered() {
        echo "END Main Menu for Registered Users:\n";
        echo "1. Check Our Menu\n";
        echo "2. Proccess Orders\n";
        echo "3. View Orders\n";
        echo "4. Cancel Orders\n";
        echo "5. Update Orders\n";
    }

    // Method to display menu items
    public function bookMenuItems($textArray, $phoneNumber) {
        // Calculate the level of the user input
        $level = count($textArray);
        if ($level == 1) {
            // Fetch available menu items from the database
            $stmt = $this->pdo->prepare("SELECT `dish_id`, `dish_name`, `price` FROM `dishes`");
            $stmt->execute();
            $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($menu_items) {
                // Display available menu items with prices
                echo "CON Available Menu Items. Choose ID of food you want:\n";
                foreach ($menu_items as $item) {
                    echo $item['dish_id'] . " - " . $item['dish_name'] . " - Rwf" . number_format($item['price'], 2) . "\n";
                }
            } else {
                // If no menu items available
                echo "END No menu items available.";
            }
        } else if ($level == 2) {
            // Retrieve the dish ID selected by the user
            $dish_id = $textArray[1];
            
            // Fetch the selected menu item from the database
            $stmt = $this->pdo->prepare("SELECT `dish_id`, `dish_name`, `price` FROM `dishes` WHERE `dish_id` = ?");
            $stmt->execute([$dish_id]);
            $menu_item = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($menu_item) {
                // Display the dish name and price, and ask the user to enter the quantity they want to order
                echo "CON Enter the quantity of " . $menu_item['dish_name'] . " you want to order - $" . number_format($menu_item['price'], 2) . "\n";
            } else {
                // If the selected dish ID is not available
                echo "END Invalid dish ID. Please try again.";
            }
        } else if ($level == 3) {
            // Ask the user to enter their PIN
            echo "CON Enter your PIN to proceed:\n";
        } else if ($level == 4) {
            // Verify the user's phone number and PIN
            $entered_pin = $textArray[3];
            $user=$this->passwordVerify($phoneNumber,$entered_pin);
            // If the user exists and the entered PIN matches the stored password
            if ($user['status']=="success") {
                // Process the order
                $dish_id = $textArray[1];
                $quantity = (int)$textArray[2];
                
                
                // Fetch dish information
                $stmt = $this->pdo->prepare("SELECT `dish_name`, `price` FROM `dishes` WHERE `dish_id` = ?");
                $stmt->execute([$dish_id]);
                $dish = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // Calculate the total price of the order
                $total_price = $dish['price'] * $quantity;
    
                // Insert the order into the `pending` table
                $stmt = $this->pdo->prepare("INSERT INTO `pending` (`dish_id`, `user_id`, `status`, `numOrders`, `price`) VALUES (?, ?, 'pending', ?, ?)");
                $stmt->execute([$dish_id, $user['data']['id'], $textArray[2], $total_price]);
                if($stmt->rowCount()>0){
                    // Confirm the order to the user
                    echo "END Order placed: " . $quantity . " x " . $dish['dish_name'] . " for $" . number_format($total_price, 2) . ".\n";
                }else{
                    // Confirm the order to the user
                echo "END Fail to Order placed: " . $quantity . " x " . $dish['dish_name'] . " for $" . number_format($total_price, 2) . ".\n";
                }
                
            } else {
                // If verification fails, return an error message
                echo "END Invalid PIN or phone number. Please try again.";
            }
        }
    }
    

    public function menuRegister($textArray, $phoneNumber) {
        // Get the level of the user input
        $level = count($textArray);
    
        // Prompt for user details based on the level of input
        if ($level == 1) {
            // Ask for the user's username
            echo "CON Enter your username\n";
        } elseif ($level == 2) {
            // Ask for the user's PIN
            echo "CON Set your PIN\n";
        } elseif ($level == 3) {
            // Ask for the user to confirm their PIN
            echo "CON Re-enter your PIN for confirmation\n";
        } elseif ($level == 4) {
            // Process registration with user input
            $username = $textArray[1];
            $pin = $textArray[2];
            $confirmPin = $textArray[3];
    
            // Check if PIN and confirm PIN match
            if ($pin != $confirmPin) {
                // If PINs don't match, return an error message
                echo "END PINs do not match. Please retry.";
            } else {
                // If PINs match, proceed with registration
    
                // Connect to the database
                include("connect.php");
    
                // Check if the user already exists based on the phone number
                try {
                    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `phone` = :phoneNumber");
                    $stmt->bindParam(':phoneNumber', $phoneNumber);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        // User already exists
                        echo "END Registration failed. User with this phone number already exists.";
                    } else {
                        // Proceed with registration
                        $stmt = $conn->prepare("INSERT INTO `users` (`username`, `phone`, `password`) VALUES (:username, :phoneNumber, :pin)");
                        
                        // Bind parameters
                        $stmt->bindParam(':username', $username);
                        $stmt->bindParam(':phoneNumber', $phoneNumber);
                        $stmt->bindParam(':pin', $pin);
    
                        // Execute the SQL statement to insert the data
                        $stmt->execute();
                        
                        if ($stmt->rowCount() > 0) {
                            // Registration successful, return a success message
                            echo "END $username, you have successfully registered.";
                        } else {
                            // Registration failed, return an error message
                            echo "END Registration failed. Please try again.";
                        }
                    }
                } catch (PDOException $e) {
                    // If there is a database error, return an error message
                    echo "END Registration failed. Please try again.";
                }
    
                // Close the database connection
                $conn = null;
            }
        }
    }
    
    

    // Method to book a food item
    public function bookFood($textArray) {
        $level = count($textArray);

        if ($level == 1) {
            // Prompt user to enter the dish ID
            echo "CON Enter the ID of the food item you want to order:\n";
        } elseif ($level == 2) {
            // Extract dish ID from user input
            $dish_id = $textArray[1];

            // Fetch dish data from the database
            $stmt = $this->pdo->prepare("SELECT `dish_name`, `price` FROM `dishes` WHERE `dish_id` = :dish_id");
            $stmt->bindParam(':dish_id', $dish_id);
            $stmt->execute();
            $dish = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dish) {
                // Insert dish data into the pending table
                $stmt_pending = $this->pdo->prepare("INSERT INTO `pending` (`dish_id`, `foodname`, `price`, `status`) VALUES (:dish_id, :foodname, :price, 'pending')");
                $stmt_pending->bindParam(':dish_id', $dish_id);
                $stmt_pending->bindParam(':foodname', $dish['dish_name']);
                $stmt_pending->bindParam(':price', $dish['price']);
                $stmt_pending->execute();

                // Display success message
                echo "END Order Placed Successfully\n";
                echo "Food Name: " . $dish['dish_name'] . "\n";
                echo "Amount Paid: $" . number_format($dish['price'], 2) . "\n";
                echo "Thank you for your order!";
            } else {
                echo "END Food not found.";
            }
        }
    }

    // Method to view order status
    public function viewOrderStatus($textArray, $phoneNumber) {
        $level = count($textArray);
    
        if ($level == 1) {
            // Prompt the user to enter their PIN to see pending orders
            echo "CON Enter Your PIN to see pending orders:\n";
        } elseif ($level == 2) {
            // Verify the PIN entered by the user
            $pin = $textArray[1];
            $user = $this->passwordVerify($phoneNumber, $pin);
    
            if ($user['status']=="success") {
                // Get the pending orders for the user
                $pendingOrders = $this->getPendingallOrdersByUserId($user['data']['id']);
    
                // Check if there are pending orders
                if (!empty($pendingOrders)) {
                    echo "CON Your pending orders:\n";
    
                    // Display each pending order
                    foreach ($pendingOrders as $order) {
                        echo "Order ID: " . $order['p_id'] . " ";
                        echo "Dish Name: " . $order['dish_name'] . " ";
                        echo "Dish Number: " . $order['numOrders'] . " ";
                        echo "Price: $" . number_format($order['price'], 2) . " ";
                        echo "Total Price: $" . number_format($order['price']*$order['numOrders'], 2) . " ";
                        echo "Status: " . $order['status'] . "\n";
                    }
                } else {
                    // No pending orders found
                    echo "END You have no pending orders.";
                }
            } else {
                // Incorrect PIN entered
                echo "END Incorrect PIN. Please try again.";
            }
        }
    }    

    public function getPendingOrdersByOrderId($orderId) {
        try {
            // Prepare the SQL query to fetch the pending orders for a specific order ID
            $stmt = $this->pdo->prepare("SELECT * FROM `pending` INNER JOIN `dishes` ON pending.dish_id = dishes.dish_id WHERE pending.p_id = :orderId AND pending.status = 'pending'");
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();
            
            // Fetch all the results as an associative array
            $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Return the array of pending orders for the order ID
            return $pendingOrders;
        } catch (PDOException $e) {
            // Handle any database errors
            echo "Error: " . $e->getMessage();
            return array(); // Return an empty array if an error occurs
        }
    }
    public function changestatusofpending($orderId, $status) {          
        try {
            // Update the status of the pending order in the database
            $stmt_update = $this->pdo->prepare("UPDATE `pending` SET `status` = :status WHERE `p_id` = :orderId");
            $stmt_update->bindParam(':status', $status);
            $stmt_update->bindParam(':orderId', $orderId);
            $stmt_update->execute();
            
            // Return the statement object
            return $stmt_update;  
        } catch (PDOException $e) {
            // Handle any database errors
            echo "Error: " . $e->getMessage();
            return false; // Return false if an error occurs
        }
    }
    public function changenumorderofpending($orderId, $numOrder) {          
        try {
            // Update the status of the pending order in the database
            $stmt_update = $this->pdo->prepare("UPDATE `pending` SET `numOrders` = :status WHERE `p_id` = :orderId");
            $stmt_update->bindParam(':status', $numOrder);
            $stmt_update->bindParam(':orderId', $orderId);
            $stmt_update->execute();
            
            // Return the statement object
            return $stmt_update;  
        } catch (PDOException $e) {
            // Handle any database errors
            echo "Error: " . $e->getMessage();
            return false; // Return false if an error occurs
        }
    }
        
    public function deleteFood($textArray, $phoneNumber) {
        $level = count($textArray);
    
        if ($level == 1) {
            // Prompt the user to enter their PIN to see pending orders
            echo "CON Enter Your PIN to see pending orders:\n";
        } elseif ($level == 2) {
            // Verify the PIN entered by the user
            $pin = $textArray[1];
            $user = $this->passwordVerify($phoneNumber, $pin);
            if ($user['status'] == "success") {
                // Get the pending orders for the user
                $pendingOrders = $this->getPendingOrdersByUserId($user['data']['id']);
    
                // Check if there are pending orders
                if (!empty($pendingOrders)) {
                    echo "CON Your pending orders. Enter Order ID you want to cancel:\n";
                    // Display each pending order
                    foreach ($pendingOrders as $order) {
                        echo "Order ID: " . $order['p_id'] . " ";
                        echo "Dish Name: " . $order['dish_name'] . " ";
                        echo "Dish Number: " . $order['numOrders'] . " ";
                        echo "Price: $" . number_format($order['price'], 2) . " ";
                        echo "Total Price: $" . number_format($order['price']*$order['numOrders'], 2) . " ";
                        echo "Status: " . $order['status'] . "\n";
                    }
                } else {
                    // No pending orders found
                    echo "END You have no pending orders.";
                }
            } else {
                // Incorrect PIN entered
                echo "END Incorrect PIN. Please try again.";
            }
        } elseif ($level == 3) {
            // Verify the PIN entered by the user
            $pin = $textArray[1];
            $orderId = $textArray[2]; // Order ID provided by the user
    
            $user = $this->passwordVerify($phoneNumber, $pin);
            if ($user['status'] == "success") {
                // Get the pending order by order ID
                $pendingOrder = $this->getPendingOrdersByOrderId($orderId);
    
                // Check if there is a pending order with the given order ID
                if (!empty($pendingOrder)) {
                    // Cancel the order by updating its status to 'Canceled'
                    $status = 'Canceled';
                    $result = $this->changestatusofpending($orderId, $status);
    
                    if ($result) {
                        echo "END Successfully canceled the order for " . $pendingOrder[0]['dish_name'] . ".\n";
                    } else {
                        echo "END Failed to cancel the order. Please try again.";
                    }
                } else {
                    // No pending orders found for the given order ID
                    echo "END No pending order found with the given Order ID.";
                }
            } else {
                // Incorrect PIN entered
                echo "END Incorrect PIN. Please try again.";
            }
        } else {
            echo "END Invalid choice.";
        }
    }
    

    public function getPendingOrdersByUserId($userId) {
        // Prepare the SQL query to fetch all pending orders for a specific user
        $stmt = $this->pdo->prepare("SELECT * FROM `pending`,dishes WHERE pending.dish_id=dishes.dish_id and pending.`user_id` = :userId AND pending.`status` = 'pending' group by pending.p_id order by pending.p_id");
        
        // Bind the user ID parameter
        $stmt->bindParam(':userId', $userId);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch all the results as an associative array
        $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return the array of pending orders for the user
        return $pendingOrders;
    }

    public function getPendingallOrdersByUserId($userId) {
        // Prepare the SQL query to fetch all pending orders for a specific user
        $stmt = $this->pdo->prepare("SELECT * FROM `pending`,dishes WHERE pending.dish_id=dishes.dish_id and pending.`user_id` = :userId group by pending.p_id order by pending.status DESC");
        
        // Bind the user ID parameter
        $stmt->bindParam(':userId', $userId);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch all the results as an associative array
        $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return the array of pending orders for the user
        return $pendingOrders;
    }

    

    // Method to update a booked food item
    public function updateFood($textArray,$phoneNumber) {
        $level = count($textArray);

        if ($level == 1) {
            // Prompt the user to enter their PIN to see pending orders
            echo "CON Enter Your PIN to see pending orders:\n";
        } elseif ($level == 2) {
            // Verify the PIN entered by the user
            $pin = $textArray[1];
            $user = $this->passwordVerify($phoneNumber, $pin);
            if ($user['status'] == "success") {
                // Get the pending orders for the user
                $pendingOrders = $this->getPendingOrdersByUserId($user['data']['id']);
    
                // Check if there are pending orders
                if (!empty($pendingOrders)) {
                    echo "CON Your pending orders. Enter Order ID you want to cancel:\n";
                    // Display each pending order
                    foreach ($pendingOrders as $order) {
                        echo "Order ID: " . $order['p_id'] . " ";
                        echo "Dish Name: " . $order['dish_name'] . " ";
                        echo "Dish Number: " . $order['numOrders'] . " ";
                        echo "Price: $" . number_format($order['price'], 2) . " ";
                        echo "Total Price: $" . number_format($order['price']*$order['numOrders'], 2) . " ";
                        echo "Status: " . $order['status'] . "\n";
                    }
                } else {
                    // No pending orders found
                    echo "END You have no pending orders.";
                }
            } else {
                // Incorrect PIN entered
                echo "END Incorrect PIN. Please try again.";
            }
        }elseif ($level == 3) {
            echo "CON Enter new number of Foods order you want.";
        } elseif ($level == 4) {
            // Verify the PIN entered by the user
            $pin = $textArray[1];
            $orderId = $textArray[2]; // Order ID provided by the user
            $user = $this->passwordVerify($phoneNumber, $pin);
            if ($user['status'] == "success") {
                // Get the pending order by order ID
                $pendingOrder = $this->getPendingOrdersByOrderId($orderId);
    
                // Check if there is a pending order with the given order ID
                if (!empty($pendingOrder)) {
                    // Cancel the order by updating its status to 'Canceled'
                    $status = 'Canceled';
                    $result = $this->changenumorderofpending($orderId, $textArray[3]);
    
                    if ($result) {
                        echo "END Successfully to change the number of order for " . $pendingOrder[0]['dish_name'] ." to be ".$textArray[3]. ".\n";
                    } else {
                        echo "END Failed to cancel the order. Please try again.";
                    }
                } else {
                    // No pending orders found for the given order ID
                    echo "END No pending order found with the given Order ID.";
                }
            } else {
                // Incorrect PIN entered
                echo "END Incorrect PIN. Please try again.";
            }
        } else {
            echo "END Invalid choice.";
        }
    }
    

    // Method to prompt for login
    public function login() {
        // Prompt for user login details
        echo "CON Please enter your username and password to login:\n";
        // Assume further implementation for login here
    }
}

?>
