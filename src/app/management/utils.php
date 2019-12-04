<?php
$messages = [];

function aggregateMessage($message){
    global $messages;
    $messages[] = $message;
}

function writeMessage(){
    global $messages;
    foreach($messages as $message){
        echo $message;
    }
}

function getMessage(){
    global $messages;
    return $messages;
}
