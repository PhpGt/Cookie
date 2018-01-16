<?php
namespace Gt\Cookie;

use ArrayAccess;
use Countable;
use DateTime;
use DateTimeInterface;
use Iterator;

class CookieHandler implements ArrayAccess, Iterator, Countable {
	/** @var Cookie[] */
	protected $cookieList = [];
	protected $iteratorIndex = 0;

	public function __construct(array $existingCookies = []) {
		foreach($existingCookies as $name => $value) {
			$this->cookieList[$name] = new Cookie($name, $value);
		}
	}

	public function has(string $name):bool {
		return isset($this->cookieList[$name]);
	}

	public function get(string $name):?Cookie {
		return $this->cookieList[$name] ?? null;
	}

	public function set(
		string $name,
		string $value,
		DateTimeInterface $expires = null,
		string $path = "/",
		string $domain = "",
		bool $secure = false,
		bool $httponly = false
	):void {
		$this->cookieList[$name] = new Cookie($name, $value);
		if(is_null($expires)) {
			$expires = new DateTime();
		}

		setcookie(
			$name,
			$value,
			$expires->getTimestamp(),
			$path,
			$domain,
			$secure,
			$httponly
		);
	}

	public function delete(string $name):void {
		setcookie(
			$name,
			"",
			-1,
			"/"
		);

		unset($this->cookieList[$name]);
	}

	public function offsetExists($offset):bool {
		return $this->has($offset);
	}

	public function offsetGet($offset):?string {
		if($this->has($offset)) {
			return $this->get($offset)->getValue();
		}

		return null;
	}

	public function offsetSet($offset, $value):void {
		throw new CookieSetException("Cookies can not be set using ArrayAccess, please use the CookieHandler::set method instead. https://www.php.gt/cookies");
	}

	public function offsetUnset($offset):void {
		$this->delete($offset);
	}

	public function current():?string {
		$name = $this->getIteratorNamedIndex();
		$cookie = $this->get($name);
		return $cookie->getValue();
	}

	public function next():void {
		$this->iteratorIndex++;
	}

	public function key():string {
		return $this->getIteratorNamedIndex();
	}

	public function valid() {
		if($this->iteratorIndex > $this->count() - 1) {
			return false;
		}

		$name = $this->getIteratorNamedIndex();
		return $this->has($name);
	}

	public function rewind() {
		$this->iteratorIndex = 0;
	}

	protected function getIteratorNamedIndex():string {
		$keys = array_keys($this->cookieList);
		return $keys[$this->iteratorIndex];
	}

	public function count():int {
		return count($this->cookieList);
	}
}