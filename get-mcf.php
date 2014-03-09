<?php

$user = $_SERVER['REMOTE_USER'];

$base_dir = dirname(__FILE__) . '/pdfs';

$ticket_name = "$base_dir/$user.pdf";

if (!file_exists($ticket_name)) {
    # run the generation script

    $s_user = escapeshellarg($user);
    $s_ticket_name = escapeshellarg($ticket_name);
    exec("cd tickets; python generate.py $s_user -o $s_ticket_name 2>&1", $output, $rv);
    if ($rv == 3) {
        header('HTTP/1.1 403 Forbidden');
        print "This user account has been withdrawn, and may not attend the competition.<br />";
        print "If you believe this account should not be withdrawn, please contact your team-leader.";
        exit();
    }
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
