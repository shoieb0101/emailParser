<?php

class fetchEmail {
	private $emails = [];
	private $urls = [];
	private $url = '';

	function __construct($url) {
		$this->url = $url;
	}

	function getContents() {
		$buffer = file_get_contents($this->url);
		return $buffer;
	}

	function startScraping() {
		// Get page content
		$pageContent = $this->getContents();
		echo 'Scraping URL: ' . $this->url . PHP_EOL;

		// Get list of all emails on page
		preg_match_all('/([\w+\.]*\w+@[\w+\.]*\w+[\w+\-\w+]*\.\w+)/is', $pageContent, $results);
		// Add the email to the email list array
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

$parseUrl = new fetchEmail('http://codefool.tumblr.com/post/15288874550/list-of-valid-and-invalid-email-addresses');
$parseUrl->startScraping();
?>