<?php
/**
 * Kahoy Crafts Cloudflare Turnstile 
 */
class kahoycrafts_cloudflare_turnstile {
	
	const CF_URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

	static public function validate($token = '', $remote_addr = '') {

	    // Request data
	    $data = array(
	        "secret" => TURNSTILE_SECRET_KEY,
	        "response" => $token,
	        "remoteip" => $remote_addr
	    );

	    // Initialize cURL
	    $curl = curl_init();

	    // Set the cURL options
	    curl_setopt($curl, CURLOPT_URL, self::CF_URL);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	    // Execute the cURL request
	    $result = curl_exec($curl);

	    $message = 'Success';

	    // Check for errors
	    if ( curl_errno($curl) ) {
	        $error_message = curl_error($curl);
	        // Handle the error the way you like it
	        $message = 'cURL Error: ' . $error_message;
	    }
	    else {
	        /* Parse Cloudflare's response and check if there are any validation errors */
	        $response = json_decode($result, true);
	        if ($response['error-codes'] && count($response['error-codes']) > 0) {
	            $message = 'Cloudflare Turnstile check failed.';
	        }
	    }

	    // Close cURL
	    curl_close($curl);

	    return $message;
	}

}
