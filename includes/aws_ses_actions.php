<?php
// Include is over 26 MB and causes out of memory error
require(__DIR__ .'/includes/aws.phar');

add_action( 'wpforms_process', 'wpf_dev_process', 10, 3 );

/**
 * Action that fires during form entry processing after initial field validation.
 *
 * @link   https://wpforms.com/developers/wpforms_process/
 *
 * @param  array  $fields    Sanitized entry field. values/properties.
 * @param  array  $entry     Original $_POST global.
 * @param  array  $form_data Form data and settings.
 *
 */
function wpf_dev_process( $fields, $entry, $form_data ) {

	// Optional, you can limit to specific forms. Below, we restrict output to
	// form #5.
	if ( $form_data['settings']['form_class'] == 'newsletter-signup' ) {
		$name = sanitize_text_field( $fields[1]['value'] );
		$email = sanitize_email( $fields[2]['value'] );
	}
	else {
		return $fields;
	}

	$sdk = new Aws\Sdk([
		'region' => 'us-west-2',
		'version' => 'latest'
	]);

	$client = $sdk->createSesV2();

	try {

		$client->createContact([
			'AttributesData' => '{"Name": "'. $name .'"}',
			'ContactListName' => 'KahoyCraftsMailingList', // REQUIRED
			'EmailAddress' => $email, // REQUIRED
			'TopicPreferences' => [
				[
					'SubscriptionStatus' => 'OPT_IN', // REQUIRED
					'TopicName' => 'News', // REQUIRED
				],
				// ...
			],
			'UnsubscribeAll' => false,
		]);

		return $fields;

	}
	catch (Exception $e) {

		wpforms()->process->errors[$form_data[ 'id' ]]['2'] = __( 'Email address is malformed or already exists.' );
	}

}
