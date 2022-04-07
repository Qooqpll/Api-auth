<?php

require_once '../ApiEngine.php';
require_once '../Validation.php';
require_once '../Error.php';

function sendJson($data = [], $header = false) {
    if($header) {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
    }

    echo json_encode($data);
}

$validation = new Validation();
$route = explode('/', $_GET['q']);
$api = new ApiEngine();
switch ($route[0]) {
    case 'signup':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['domain']) && isset($_POST['login']) && isset($_POST['password'])
                && isset($_POST['repeatPassword']) && isset($_POST['rememberMe'])
            ) {
                if($validation->getConfirmCheck($_POST['password'], $_POST['repeatPassword'])) {

                    $api->setData($_POST);

                    if ($api->checkUserByDomain()) {
                        $api->signUp();
                        sendJson(ERROR['00'], true);
                    } else {
                        sendJson(ERROR['01'], true);
                    }

                } else {
                    sendJson($validation->getError(), true);
                }
            }
        }
        break;
    case 'signin' :
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['domain']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['rememberMe'])) {

                $api->setData($_POST);

                if($api->checkAuth()) {
                    $api->signIn();
                    //setcookie('rememberMe', $_POST['login']);
                    print_r($_COOKIE);
                    sendJson(ERROR['00'], true);
                }
            }
        }
        break;
    default :
        //sendJson(ERROR['05'], true);
}

?>