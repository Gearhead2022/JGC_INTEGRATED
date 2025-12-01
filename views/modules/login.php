<?php 
 $backup = (new Connection)->connect()->query("SELECT * from login_requests ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
 if(empty($backup)){
   $id = 0;
 }else{
   $id = $backup['id'];
 }
 $last_id = $id + 1;
 $requestID = "RI" . str_repeat("0",5-strlen($last_id)).$last_id;     

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="views/img/JGC.png" type="image/x-icon">
    <title>Login</title>
    <style>
        body, html {
            font-family: Arial, Helvetica, sans-serif;
        }
        form {
            width: 100%;
            max-width: 400px;
            padding: 60px;
            margin: 0 auto;
            margin-top: 2%;
            background-color: #f9f9f9;
        }
        .form-control {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
            margin: 5px auto;
            padding: 15px;
            box-shadow: 0px 5px 5px #ccc;
            border-radius: 5px;
            border-top: 1px solid #e9e9e9;
            display: block;
            text-align: center;
        }
        .signup {
            background-color: blue;
            margin-bottom: 20px;
        }
        .card {
            width: 100%;
            max-width: 500px;
            margin: auto;
            margin-top: 50px;
        }
        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
        }
        img.avatar {
            width: 40%;
            border-radius: 50%;
        }
        h2, p {
            text-align: center;
        }
        #logo1 {
            width: 250px;
            height: 59px;
            margin-top: 15px;
        }
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }
        }

        .card-header {
    display: flex;
    /* align-content: center; */
    align-items: center;
    justify-content: center;
}
    </style>
    <link href="views/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let conn;
        let isWebSocketOpen = false;
        function initializeWebSocket() {
            conn = new WebSocket('wss://jgcintegratedsystems.com/ws/');  // Use your local IP address
            conn.onopen = function() {
                isWebSocketOpen = true;
                console.log('WebSocket connection opened');
            };
            conn.onclose = function() {
                isWebSocketOpen = false;
                console.log('WebSocket connection closed. Reconnecting...');
                setTimeout(initializeWebSocket, 5000);
            };
            conn.onmessage = function(event) {
                const response = JSON.parse(event.data);
                console.log('Response received:', response);
                const storedRequest_id = sessionStorage.getItem('request_id');
                if (response.type === 'login_confirmation' && response.request_id === storedRequest_id) {
                // Send an AJAX request to store session
                    $.ajax({
                        url: 'ajax/storesession.php',  // URL of your backend script that handles session storage
                        method: 'POST',
                        data: { username: storedRequest_id },
                        success: function(storeSessionResponse) {
                            // Parse the response if it's a string
                            if (typeof storeSessionResponse === 'string') {
                                storeSessionResponse = JSON.parse(storeSessionResponse);
                            }
                            if (storeSessionResponse.success) {
                                // If session is successfully stored, display the success message
                                Swal.fire({
                                    title: "Success!",
                                    text: "Admin has confirmed your login!",
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then(() => {
                                    // Redirect the user after the session is stored
                                    window.location.href = 'index.php';
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: "Failed to store session. Please try again.",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error storing session:', error);
                            Swal.fire({
                                title: "Error",
                                text: "An error occurred while storing the session.", 
                                icon: "error",
                                confirmButtonText: "OK"
                             });
                          }
                   });
               }
               else if (response.type === 'reject_login') {
                Swal.fire({
                    title: "Login request has been rejected.",
                    icon: "warning",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Reload the page after clicking OK
                    }
                });

                }
                else if (response.type === 'error') {
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                }
            };
                conn.onerror = function(error) {
                    console.error('WebSocket error:', error);
                    Swal.fire({
                        title: "Error",
                        text: "WebSocket connection error. Please try again later.",
                        icon: "error",
                        confirmButtonText: "OK",
                     });
                 };
         }

        window.onload = initializeWebSocket;

        function handleLogin(event) {
            event.preventDefault();
            const username = $('#username').val();
            const password = $('#password').val();
            const request_id = $('#request_id').val();
            const $button = $('.save');
            $button.prop('disabled', true); // Disable button during request

            $.ajax({
                url: 'ajax/login_handler.php',
                type: 'POST',
                dataType: 'json',
                data: { username, password, request_id },
            success: function(data) { 
                    if (data.success) {
                        let request_id = data.request_id;
                        let full_name = data.full_name;
                        if (conn.readyState === WebSocket.OPEN) {
                            conn.send(JSON.stringify({ type: 'new_login_request', username, request_id, full_name }));
                            sessionStorage.setItem('request_id', request_id);
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: "Unable to send login request to admin. Please try again later.",
                                icon: "error",
                                confirmButtonText: "OK",
                            });
                            $button.prop('disabled', false); // Re-enable button on error
                            return;
                        }
                        let timerInterval;
                        Swal.fire({
                            title: "Request Sent",
                            html: "Login request sent to admin. Please wait for confirmation.<br><strong>Closing in <b>120</b> seconds...</strong>",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            icon: "info",
                            didOpen: () => {
                                Swal.showLoading();
                                let timer = 120;  // Set initial countdown value (120 seconds for 2 minutes)
                                timerInterval = setInterval(() => {
                                    timer--;
                                    Swal.getHtmlContainer().querySelector('b').textContent = timer;  // Update the timer in the alert
                                    if (timer <= 0) {
                                        clearInterval(timerInterval);  // Clear the interval when timer is done
                                    }
                                }, 1000);  // Update every second
                            },
                            willClose: () => {
                                clearInterval(timerInterval);  // Ensure the interval is cleared if the alert is closed
                            }
                        });

                        // Set a delay before reloading the page (after 2 minutes)
                        setTimeout(function() {
                            Swal.close(); // Close the alert after the delay
                            location.reload(); // Reload the page after the delay
                        }, 120000);  // 120000 milliseconds = 120 seconds = 2 minutes
                        // 5000 milliseconds = 5 seconds delay
                    } else {
                        if(data.type == 'admin' || data.type == 'login_admin'){
                            Swal.fire({
                            title: "success",
                            text: data.message,
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then(() => {
                        window.location.href = 'index.php';
                    });
                        }else{
                            Swal.fire({
                            title: "Error",
                            text: data.message,
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                        }
                    }
                    $button.prop('disabled', false); // Re-enable button after response
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                    Swal.fire({
                        title: "Error",
                        text: 'An error occurred while processing your request. Please try again.',
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                    $button.prop('disabled', false); // Re-enable button after error
                }
            });
        }

        function generateRequestID(){
            function generateRequestID() {
                    $.ajax({
                        url: 'get_last_request_id.php', // URL to the PHP script
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.requestID) {
                                console.log("New Request ID: " + response.requestID);
                                // You can now use the new Request ID as needed
                                // For example, display it in an input field
                                $('#requestIDInput').val(response.requestID);
                            } else {
                                console.error("Failed to generate Request ID.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + status + ": " + error);
                        }
                    });
                }
                // Call the function to generate a new request ID
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <img id="logo1" src="views/img/JGC LOGO.png" alt="">
            </div>
            <div class="card-body">
                <form onsubmit="handleLogin(event)">
                    <div class="nav">
                        <input type="text" hidden class="form-control" name="request_id" id="request_id" value="<?php echo $requestID; ?>">
                        <label for="username"><b>Username</b></label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" required autocomplete="off" aria-label="Enter your username">
                        <label for="password"><b>Password</b></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required autocomplete="off" aria-label="Enter your password">
                        <button type="submit" class="save">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
