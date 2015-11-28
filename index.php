<?php

class fetchEmail {
	private $emails = [];
	private $urls = [];
	private $url = '';

	function __construct($url) {
		$this->url = $url;
	}

	function validateUrl() {
		if (filter_var($this->url, FILTER_VALIDATE_URL) === FALSE) {
			return false;
		}

		return true;
	}

	function getContents() {
		if (!$this->validateUrl()) {
			return false;
		}
		$buffer = file_get_contents($this->url);

		return $buffer;
	}

	function startScraping() {
		// get page content
		$pageContent = $this->getContents();
		if ($pageContent) {
			echo 'Parsing URL: ' . $this->url . PHP_EOL;

			// get emails from the URL
			preg_match_all('/([\w+\.]*\w+@[\w+\.]*\w+[\w+\-\w+]*\.\w+)/is', $pageContent, $results);
			// add emails to array
			$insertCount = 0;
			foreach ($results[1] as $email) {
				if (in_array($email, $this->emails)) {
					continue;
				}

				$this->emails[] = $email;
				$insertCount++;
			}
			var_dump($this->emails);
		}
	}
}

$parseUrl = new fetchEmail('http://codefool.tumblr.com/post/15288874550/list-of-valid-and-invalid-email-addresses');
$parseUrl->startScraping();
?>