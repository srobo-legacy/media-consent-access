<?php

$user = $_SERVER['REMOTE_USER'];

$base_dir = dirname(__FILE__) . '/tickets/pdfs';

$ticket_name = "$base_dir/$user.pdf";

if (!file_exists($ticket_name)) {
    # run the generation script

    exec("cd pdfs ; python generate.py $user -y 2013 -d 'April 13th-14th (Doors open 9:00)' -l 'https://www.studentrobotics.org/comp' -o $ticket_name 2>&1", $output, $rv);
    if (!file_exists($ticket_name)) {
        header('HTTP/1.1 500 Internal Server Error');
        exit();
    }
}

header('Content-type: application/pdf');
header('Content-length: ' . filesize($ticket_name));
header('Content-Disposition: attachment; filename="mediaconsent.pdf"');
readfile($ticket_name);
