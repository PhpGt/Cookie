<?php
namespace Gt\Cookie;

/**
 * Provide a list of valid characters for use in HTTP cookies, as per RFC6265.
 * @see http://www.ietf.org/rfc/rfc6265.txt
 * @see https://stackoverflow.com/a/1969339/431780
 */
class Validity {
// Note that name/value characters are additional to alphanumerics:
	const NAME_CHARACTERS = "!#$%&'*+-.^_`|~";
	const VALUE_CHARACTERS = "!#$%&'()*+-./:=><?@[]^_`{|}~ ";
	const ALPHANUMERIC_CHARACTERS = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

	/**
	 * @return string[]
	 */
	public static function getValidNameCharacters():array {
		return str_split(self::ALPHANUMERIC_CHARACTERS . self::NAME_CHARACTERS);
	}

	/**
	 * @return string[]
	 */
	public static function getValidValueCharacters():array {
		return str_split(self::ALPHANUMERIC_CHARACTERS . self::VALUE_CHARACTERS);
	}
}