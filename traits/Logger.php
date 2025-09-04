<?php

namespace traits\Logger;

trait Logger {

    public function logmessage( string $message) : void {
        // echo "LOG :" . date("d-m-y H:i:s") ." $message\n";
        $logs = fopen("Logs.txt","a") or die("Unable to open file!");
        fwrite($logs,"LOG : $message " . date("d-m-y H:i:s") . " \n");
        fclose($logs);

        
    }
}

