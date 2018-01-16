<?php
namespace Gt\Cookie\Test;

use Gt\Cookie\Cookie;
use Gt\Cookie\Validity;
use PHPUnit\Framework\TestCase;

class CookieTest extends TestCase {
	/**
	 * @dataProvider dataNameValue
	 */
	public function testGetName(string $name, string $value) {
		$cookie = new Cookie($name, $value);
		self::assertEquals($name, $cookie->getName());
	}

	/**
	 * @dataProvider dataNameValue
	 */
	public function testGetValue(string $name, string $value) {
		$cookie = new Cookie($name, $value);
		self::assertEquals($value, $cookie->getValue());
	}

	public static function dataNameValue():array {
		$data = [];

		for($i = 0; $i < 10; $i++) {
			$row = [
				self::getRandomText(Validity::getValidNameCharacters()),
				self::getRandomText(Validity::getValidValueCharacters()),
			];
			$data []= $row;
		}

		return $data;
	}

	protected static function getRandomText(
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