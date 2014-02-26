<?php

$user = $_SERVER['REMOTE_USER'];

$base_dir = dirname(__FILE__) . '/pdfs';

$ticket_name = "$base_dir/$user.pdf";

if (!file_exists($ticket_name)) {
    # run the generation script

    exec("cd tickets; python generate.py $user -o $ticket_name 2>&1", $output, $rv);
    if (!file_exists($ticket_name)) {
        header('HTTP/1.1 500 Internal Server Error');
        print "Internal error -- please contact info@studentrobotics.org";
        exit();
    }
}

header('Content-type: application/pdf');
header('Content-length: ' . filesize($ticket_name));
header('Content-Disposition: attachment; filename="mediaconsent.pdf"');
readfile($ticket_name);
