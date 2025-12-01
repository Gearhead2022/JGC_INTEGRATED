<?php
#require '../vendor/autoload.php'; // Include Composer's autoloader

#require_once "../controllers/account.controller.php";
#require_once "../models/account.model.php";
#require_once "../views/modules/session.php";

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../controllers/account.controller.php';
require __DIR__ . '/../models/account.model.php';
require __DIR__ . '/../views/modules/session.php';



use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server as ReactServer;

class WebSocketServer implements MessageComponentInterface {
    protected $clients;
    private $db;

    public function __construct() {
        $this->clients = new \SplObjectStorage; // Store all active connections
    }
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }
    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        try {
            $username =strtoupper($data['username']);
            $request_id = $data['request_id'];
            if ($data['type'] === 'new_login_request') {
                // Store the login request and associate the connection with the username
                $from->username = $data['username'];
                $from->request_id = $data['request_id'];
                $full_name = $data['full_name'];
                
                date_default_timezone_set('Asia/Manila'); // Set timezone to Philippines
                $date = date('F j, Y \a\t h:i:s A');

              
                // Store login request in the database
            
                $add = (new ControllerAccounts)->ctrAddLoginRequest($username, $request_id, $full_name);
                // Notify admin about the new login request
                foreach ($this->clients as $client) {
                    if ($client !== $from) {
                        $client->send(json_encode(['type' => 'new_login_request', 'username' => $data['username'], 'request_id' => $data['request_id'], 'date'=> $date]));
                    }
                }
            } elseif ($data['type'] === 'login_confirmation') {
                $coordinator = $data['coordinator'];
                $approved_time = date("Y-m-d H:i:s");
                $is_approved = 1;
                $update = (new ControllerAccounts)->ctrUpdateLoginRequest($request_id, $coordinator, $approved_time, $is_approved);
                foreach ($this->clients as $client) { 
                    if (isset($client->username) && $client->username === $data['username']) {
                        $client->send(json_encode(['type' => 'login_confirmation', 'request_id' => $data['request_id']]));
                    }
                }
            }
            elseif ($data['type'] === 'reject_login') {
                $coordinator = $data['coordinator'];
                $approved_time = date("Y-m-d H:i:s");
                $is_approved = 3;
                $update = (new ControllerAccounts)->ctrUpdateLoginRequest($request_id, $coordinator, $approved_time, $is_approved);
                foreach ($this->clients as $client) { 
                    if (isset($client->username) && $client->username === $data['username']) {
                        $client->send(json_encode(['type' => 'reject_login', 'request_id' => $data['request_id']]));
                    }
                }
            }
        } catch (\Exception $e) {
            $from->send(json_encode(['type' => 'error', 'message' => $e->getMessage()]));
        }


        if (isset($data['message']) && $data['message'] === 'get_notification_count') {
            // $type = $data['type'];
            // $notification = (new ControllerPermits)->ctrGetNotification($type);
            // $count = count($notification); // count the notifications
            // echo "Notification Result:\n";
            // var_dump($notification); // show in console
            foreach ($this->clients as $client) {
                $client->send(json_encode([
                    'type' => 'notification_count',
                    // 'count' => $count,
                    // 'notifications' => $notification // send actual data (optional)
                ]));
            }
        }



    }
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
// Initialize the ReactPHP event loop
$loop = Factory::create();
// Create the WebSocket server, and wrap it in an HTTP server
$webSocket = new WsServer(new WebSocketServer());
$http = new HttpServer($webSocket);
// Create a ReactPHP socket server that listens on port 8080
$socketServer = new ReactServer('0.0.0.0:9000', $loop); // Bind to all network interfaces
// Create the IoServer to run the WebSocket over the HTTP server
$server = new IoServer($http, $socketServer, $loop);

echo "WebSocket server running at ws://jgccorporatesystems.site:9000\n";
$loop->run();
