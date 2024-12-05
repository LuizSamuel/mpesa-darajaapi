<?php
header("Content-Type: application/json");

// Capture the JSON response from Safaricom
$stkCallbackResponse = file_get_contents('php://input');

if ($stkCallbackResponse) {
    // Log the response to a file
    $logFile = "Mpesastkresponse.json";
    $log = fopen($logFile, "a");
    if ($log) {
        fwrite($log, $stkCallbackResponse . PHP_EOL);
        fclose($log);
    } else {
        error_log("Failed to open log file: $logFile");
    }

    // Decode and handle the callback payload
    $response = json_decode($stkCallbackResponse, true);

    if (isset($response['Body']['stkCallback'])) {
        $stkCallback = $response['Body']['stkCallback'];
        $ResultCode = $stkCallback['ResultCode'] ?? null;
        $ResultDesc = $stkCallback['ResultDesc'] ?? null;
        $CheckoutRequestID = $stkCallback['CheckoutRequestID'] ?? null;

        // Log the decoded callback data for verification
        $callbackLogFile = "CallbackLog.json";
        $logCallback = fopen($callbackLogFile, "a");
        if ($logCallback) {
            fwrite($logCallback, json_encode($stkCallback, JSON_PRETTY_PRINT) . PHP_EOL);
            fclose($logCallback);
        }

        // Optionally handle success or failure
        if ($ResultCode === 0) {
            // Payment was successful
            // Perform further actions (e.g., updating a database or sending an email)
        } else {
            // Payment failed
            error_log("STK Push failed with ResultCode $ResultCode: $ResultDesc");
        }
    } else {
        error_log("Invalid callback structure: " . json_encode($response));
    }
} else {
    error_log("No data received in the callback.");
}
