<?php
try {
    @require 'pharma.conf.php'; # Configurations
    if (Controller::connect()) {
        if (isset($_GET['do'])) {
            @require (strtolower($_GET['do']) . '/index.php');
        } else {
            echo Controller::response([
                'message' => 'ok'
            ], 1);
        }
    } else {
        Controller::auth();
        echo Controller::response([
            'message' => 'connection_failed'
        ]);
    }
} catch (Exception $e) {
    echo Controller::response([
        'message' => $e->getMessage()
    ]);
}
    