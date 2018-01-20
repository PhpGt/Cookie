Object oriented cookie handler.
-------------------------------

This library is a simple object oriented alternative to the `$_COOKIE` superglobal that can be read using the same associative array style code. The `Cookie` class represents cookie data in immutable objects, meaning that the state of the request/response cookies cannot be accidentally changed by undisclosed areas of code.

***

<a href="https://circleci.com/gh/PhpGt/Cookie" target="_blank">
	<img src="https://img.shields.io/circleci/project/PhpGt/Cookie/master.svg?style=flat-square" alt="Build status" />
</a>
<a href="https://scrutinizer-ci.com/g/PhpGt/Cookie" target="_blank">
	<img src="https://img.shields.io/scrutinizer/g/PhpGt/Cookie/master.svg?style=flat-square" alt="Code quality" />
</a>
<a href="https://scrutinizer-ci.com/g/PhpGt/Cookie" target="_blank">
	<img src="https://img.shields.io/scrutinizer/coverage/g/PhpGt/Cookie/master.svg?style=flat-square" alt="Code coverage" />
</a>
<a href="https://packagist.org/packages/PhpGt/Cookie" target="_blank">
	<img src="https://img.shields.io/packagist/v/PhpGt/Cookie.svg?style=flat-square" alt="Current version" />
</a>
<a href="http://www.php.gt/cookie" target="_blank">
	<img src="https://img.shields.io/badge/docs-www.php.gt/cookie-26a5e3.svg?style=flat-square" alt="PHP.Gt/Cookie documentation" />
</a>

## Example usage: xyz.

// TODO.

## What's not covered?

This library does not touch on encrypting cookies. To store sensitive information across HTTP requests, use a session variable. To ensure cookies can't be read by JavaScript, use a secure HTTP-only cookie.
