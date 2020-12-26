<?php
namespace Gt\Cookie;

use Gt\Cookie\Test\Helper\Override;

function setcookie() {
	Override::call("setcookie", func_get_args());
}