<?php
namespace Gt\Cookie;

class Cookie {
	protected $name;
	protected $value;

	public function __construct(string $name, string $value = "") {
		if(!Validity::isValidName($name)) {
			throw new InvalidCharactersException("Name contains invalid characters: $name");
		}
		if(!Validity::isValidValue($value)) {
			throw new InvalidCharactersException("Value contains invalid characters: $value");
		}

		$this->name = $name;
		$this->value = $value;
	}

	public function getName():string {
		return $this->name;
	}

	public function getValue():string {
		return $this->value;
	}

	public function withValue(string $value):self {
		if(!Validity::isValidValue($value)) {
			throw new InvalidCharactersException($value);
		}

		$clone = clone($this);
		$clone->value = $value;
		return $clone;
	}
}