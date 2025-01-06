<?php
/**
 * Kahoy Crafts Big Mailer
 */
class kahoycrafts_big_mailer {

	const API_URL = 'https://api.bigmailer.io/v1/brands/63e25b44-7bfe-45a9-8948-ef354714783d';

	static public function add_contact($email, $name) {

		// Encode the data in a new array in JSON format
		$data = json_encode([
			"email" => $email,
			"list_ids" => [
				//'3b76642d-8d8d-4cf9-b039-976f59ac94a2',
				'ca8a5659-199e-4ca6-9062-2f0aa4544f23',
			],
			"field_values" => [
				['name' => 'FIRST_NAME', 'string' => $name]
			]
		]);
	    
		// Finally send the data to your custom endpoint
	    $ch = curl_init(self::API_URL ."/contacts/upsert");
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, [
	    	"X-API-Key: ". BIG_MAILER_API_KEY,
	    	"accept: application/json",
	    	"content-type: application/json"
	    ]);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5); //Optional timeout value
	    curl_setopt($ch, CURLOPT_TIMEOUT, 5); //Optional timeout value

	    $result = curl_exec($ch);
	    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	    $message = 'Success';

	    if ( $http_code != 200 ) {
	    	$response = json_decode($result);

	    	if ($response->message) {
	    		$message = $response->message;
	    	} else {
	    		$message = 'Sorry, an error occurred.';
	    	}
	    }

	    curl_close($ch);

	    return $message;
	}

}
