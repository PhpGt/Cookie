<?php
namespace Gt\Cookie\Test\Helper;

class Helper {
	public static function getRandomText(
		array $charSet,
		int $minLength = 1,
		int $maxLength = 100
	):string {
		$text = "";
		$length = rand($minLength, $maxLength);

		while(strlen($text) < $length) {
			$randIndex = array_rand($charSet);
			$text .= $charSet[$randIndex];
		}

		return $text;
	}
}