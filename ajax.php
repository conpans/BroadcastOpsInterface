<?php
if (isset($_GET['domain'])) {
    $domain = escapeshellarg($_GET['domain']); // Escape the domain to prevent command injection
    $output = null;
    $status = null;

    // Determine the correct ping option based on the operating system
    $pingOption = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? '-n' : '-c';

    // Execute the ping command
    exec("ping " . $pingOption . " 1 " . $domain, $output, $status);

    // If the status is 0, it means the ping was successful
    echo $status === 0 ? "1" : "0"; // Online or Offline
} else {
    echo "No domain provided";
}
?>
