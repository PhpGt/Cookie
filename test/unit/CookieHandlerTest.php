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