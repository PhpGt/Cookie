<?php

namespace Gt\Cookie\Test;

use Gt\Cookie\Cookie;
use Gt\Cookie\CookieHandler;
use Gt\Cookie\Test\Helper\Helper;
use Gt\Cookie\Validity;
use PHPUnit\Framework\TestCase;

class CookieHandlerTest extends TestCase {
	/**
	 * @dataProvider dataCookie
	 */
	public function testHas(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);

		foreach($cookieData as $key => $value) {
			self::assertTrue($cookieHandler->has($key));
		}
	}

	/**
	 * @dataProvider dataCookie
	 */
	public function testHasNot(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);
		$fakeData = [];

		for($i = 0; $i < 10; $i++) {
			$name = Helper::getRandomText(Validity::getValidNameCharacters());
			$value = Helper::getRandomText(Validity::getValidValueCharacters());

			$fakeData[$name] = $value;
		}

		foreach($fakeData as $name => $value) {
			self::assertFalse($cookieHandler->has($name));
		}
	}

	/**
	 * @dataProvider dataCookie
	 */
	public function testGet(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);

		foreach($cookieData as $name => $value) {
			$cookie = $cookieHandler->get($name);
			$this->assertEquals($value, $cookie->getValue());
		}
	}

	/**
	 * @dataProvider dataCookie
	 */
	public function testGetNotExists(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);

		$fakeData = [];

		for($i = 0; $i < 10; $i++) {
			$name = Helper::getRandomText(Validity::getValidNameCharacters());
			$value = Helper::getRandomText(Validity::getValidValueCharacters());

			$fakeData[$name] = $value;
		}

		foreach($fakeData as $name => $value) {
			self::assertNull($cookieHandler->get($name));
		}
	}

	/**
	 * @dataProvider dataCookie
	 */
	public function testDelete(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);
		$deleted = [];
		$numToDelete = rand(1, count($cookieData));

		for($i = 0; $i < $numToDelete; $i++) {
			$nameToDelete = array_rand($cookieData);
			$cookieHandler->delete($nameToDelete);
			$deleted []= $nameToDelete;
		}

		foreach($deleted as $name) {
			self::assertFalse($cookieHandler->has($name));
		}
	}

	/**
	 * @dataProvider dataCookie
	 */
	public function testOffsetGet(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);

		foreach($cookieData as $name => $expectedValue) {
			$actualValue = $cookieHandler[$name];
			self::assertEquals($expectedValue, $actualValue);
		}
	}

	public function dataCookie():array {
		$data = [];

		for($dataCount = 0; $dataCount < 10; $dataCount++) {
			$minCookies = 1;
			$maxCookies = 100;
			$numCookies = rand($minCookies, $maxCookies);
			$cookieData = [];

			for($i = 0; $i < $numCookies; $i++) {
				$name = Helper::getRandomText(Validity::getValidNameCharacters());
				$value = Helper::getRandomText(Validity::getValidValueCharacters());

				$cookieData[$name] = $value;
			}

			$data []= [
				$cookieData
			];
		}

		return $data;
	}
}