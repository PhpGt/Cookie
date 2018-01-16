<?php
namespace Gt\Cookie\Test;

use Gt\Cookie\Cookie;
use Gt\Cookie\InvalidCharactersException;
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

	/**
	 * @dataProvider dataNameValue
	 */
	public function testConstructInvalidName(string $name, string $value) {
		$name = $this->injectInvalidCharacters($name);

		self::expectException(InvalidCharactersException::class);
		new Cookie($name);
	}

	/**
	 * @dataProvider dataNameValue
	 */
	public function testConstructInvalidValue(string $name, string $value) {
		$value = $this->injectInvalidCharacters($value);

		self::expectException(InvalidCharactersException::class);
		new Cookie($name, $value);
	}

	/**
	 * @dataProvider dataNameValue
	 */
	public function testSetInvalidValue(string $name, string $value) {
		$value = $this->injectInvalidCharacters($value);

		$cookie = new Cookie($name);
		self::expectException(InvalidCharactersException::class);
		$cookie->withValue($value);
	}

	/**
	 * @dataProvider dataNameValue
	 */
	public function testWithValue(string $name, string $value) {
		$cookie = new Cookie($name, $value);
		$value = $cookie->getValue();

		$eulav = strrev($value);
		$eikooc = $cookie->withValue($eulav);
		self::assertNotSame($eikooc, $cookie);
		self::assertNotEquals($value, $eikooc->getValue());
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

	protected function injectInvalidCharacters(
		string $name,
		int $minLength = 1,
		int $maxLength = 100
	):string {
		$invalidCharacters = str_split(",´ō▓Æ®§×ƒ²┐╔", 1);
		$length = rand($minLength, $maxLength);

		for($i = 0; $i < $length; $i++) {
			$pos = rand(0, strlen($name));
			$charKey = array_rand($invalidCharacters);
			$char = $invalidCharacters[$charKey];

			$name = substr_replace(
				$name,
				$char,
				$pos
			);
		}

		return $name;
	}
}