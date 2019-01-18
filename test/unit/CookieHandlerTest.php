<?php

namespace Gt\Cookie\Test;

use Gt\Cookie\Cookie;
use Gt\Cookie\CookieHandler;
use Gt\Cookie\CookieSetException;
use Gt\Cookie\Test\Helper\Helper;
use Gt\Cookie\Validity;
use PHPUnit\Framework\TestCase;

class CookieHandlerTest extends TestCase {
	/**
	 * @dataProvider dataCookie
	 */
	public function testcontains(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);

		foreach($cookieData as $key => $value) {
			self::assertTrue($cookieHandler->contains($key));
		}
	}

	/**
	 * @dataProvider dataCookie
	 */
	public function testHasNot(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);
		$fakeData = $this->generateFakeData();

		foreach($fakeData as $name => $value) {
			self::assertFalse($cookieHandler->contains($name));
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

		$fakeData = $this->generateFakeData();

		foreach($fakeData as $name => $value) {
			self::assertNull($cookieHandler->get($name));
		}
	}

	/**
	 * @dataProvider dataCookie
	 * @runInSeparateProcess
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
			self::assertFalse($cookieHandler->contains($name));
		}
	}

	/**
	 * @dataProvider dataCookie
	 * @runInSeparateProcess
	 */
	public function testOffsetUnset(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);
		$deleted = [];
		$numToDelete = rand(1, count($cookieData));

		for($i = 0; $i < $numToDelete; $i++) {
			$nameToDelete = array_rand($cookieData);
			unset($cookieHandler[$nameToDelete]);
			$deleted []= $nameToDelete;
		}

		foreach($deleted as $name) {
			self::assertFalse($cookieHandler->contains($name));
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

	/**
	 * @dataProvider dataCookie
	 */
	public function testOffsetGetNotExist(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);
		$fakeData = $this->generateFakeData();

		foreach($fakeData as $name => $value) {
			self::assertNull($cookieHandler[$name]);
		}
	}

	/**
	 * @dataProvider dataCookie
	 */
	public function testOffsetExists(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);

		foreach($cookieData as $name => $value) {
			self::assertTrue(isset($cookieHandler[$name]));
		}
	}

	/**
	 * @dataProvider dataCookie
	 */
	public function testOffsetNotExists(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);
		$fakeData = $this->generateFakeData();

		foreach($fakeData as $name => $value) {
			self::assertFalse(isset($cookieHandler[$name]));
		}
	}

	/**
	 * @dataProvider dataCookie
	 * @runInSeparateProcess
	 */
	public function testSet(array $cookieData) {
		$cookieHandler = new CookieHandler();

		foreach($cookieData as $name => $value) {
			$cookieHandler->set($name, $value);
		}

		foreach($cookieData as $name => $value) {
			$cookie = $cookieHandler->get($name);
			self::assertEquals(
				$value,
				$cookie->getValue()
			);
		}
	}

	/** @dataProvider dataCookie */
	public function testSetDelete(array $cookieData) {
		$cookieHandler = new CookieHandler();

// Add known-to-be-tricky cookies: (for issue #14)
		$cookieData['1'] = "something";
		$cookieData['0'] = "something";
		$cookieData['tGQBfw\'#68u36UkhMh8WjjGNXeQcj+oKmOMGhx9zxH-_rMwb6cLo%k4zGuE7HOLnR$%|8RKKmmcNR0i'] = 'y3=98e~gyG\'vN=T_7wiy0Fz1P*!Sx{9I&nO+U-\'YPG$4rv]Lj0><V~?B)b(x6fX[5V&NC6hY{-?^KC+-@a:Q{n';
		$cookieData['02%AZ2RRhx~jOG^YN9^0kf\'%aLA!v8^^^Xe8oO^t6*'] = 'v9|/%d2_UAg2WTd[Hfzj`Q]O<M KU+v7gYSf-_}eu&Y+r~s^tWS[=!Hx`ZtXBG4|{~qMh9 V>?)+i3XdmCYb+_~BR]y';

		foreach($cookieData as $name => $value) {
			$cookieHandler->set($name, $value);
		}

		$deletedNames = [];
		$numToDelete = rand(1, count($cookieData));

		for($i = 0; $i < $numToDelete; $i++) {
			$nameToDelete = array_rand($cookieData);
			$cookieHandler->delete($nameToDelete);
			$deletedNames [] = $nameToDelete;
		}

		foreach($cookieData as $name => $value) {
			$cookie = $cookieHandler->get($name);

			if(in_array($name, $deletedNames)) {
				self::assertNull($cookie);
			}
			else {
				self::assertEquals(
					$value,
					$cookie->getValue()
				);
			}
		}
	}

	/**
	 * @dataProvider dataCookie
	 */
	public function testIterator(array $cookieData) {
		$cookieHandler = new CookieHandler($cookieData);

		$count = 0;

		foreach($cookieHandler as $name => $value) {
			self::assertEquals($cookieData[$name], $value);
			$count ++;
		}

		self::assertEquals(count($cookieData), $count);
	}

	public function testOffsetSet() {
		$cookieHandler = new CookieHandler();
		self::expectException(CookieSetException::class);
		$cookieHandler["anything"] = "nothing";
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

	protected function generateFakeData(int $amount = 10) {
		$fakeData = [];

		for($i = 0; $i < $amount; $i++) {
			$name = Helper::getRandomText(Validity::getValidNameCharacters());
			$value = Helper::getRandomText(Validity::getValidValueCharacters());

			$fakeData[$name] = $value;
		}

		return $fakeData;
	}
}