<?php

// Taken from http://net.tutsplus.com/tutorials/php/secure-your-forms-with-form-keys/

class formKey {
	// Here we store the generated form key
	private $formKey;

	// Here we store the old form key (more info at step 4)
	private $old_formKey;

	// The constructor stores the form key (if one excists) in our class variable
	function __construct() {
		// We need the previous key so we store it
		if (isset($_SESSION['form_key'])) {
			$this->old_formKey = $_SESSION['form_key'];
		}
	}

	//Function to generate the form key
	private function generateKey() {
		//Get the IP-address of the user
		$ip = $_SERVER['REMOTE_ADDR'];

		//We use mt_rand() instead of rand() because it is better for generating random numbers.
		//We use 'true' to get a longer string.
		//See http://www.php.net/mt_rand for a precise description of the function and more examples.
		$uniqid = uniqid(mt_rand(), true);

		//Return the hash
		return md5($ip.$uniqid);
	}

	//Function to output the form key
	public function outputKey() {
		// Generate the key and store it inside the class
		$this->formKey = $this->generateKey();

		// Store the form key in the session
		$_SESSION['form_key'] = $this->formKey;

		//Output the form key
		return $this->formKey;
	}

	// Function that validated the form key data
	public function validate($check_formKey = null) {
		if ($check_formKey == null) {
			$check_formKey = $_POST['form_key'];
		}
		//We use the old formKey and not the new generated version
		if ($check_formKey == $this->old_formKey) {
			// The key is valid, return true.
			return true;
		}
		else {
			// The key is invalid, return false.
			return false;
		}
	}
}
?>