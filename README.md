Object oriented cookie handler.
-------------------------------

This library is a simple object oriented alternative to the `$_COOKIE` superglobal that can be read using the same associative array style code. The `Cookie` class represents cookie data in immutable objects, meaning that the state of the request/response cookies cannot be accidentally changed by undisclosed areas of code.

***

<a href="https://github.com/PhpGt/Cookie/actions" target="_blank">
	<img src="https://badge.status.php.gt/cookie-build.svg" alt="Build status" />
</a>
<a href="https://scrutinizer-ci.com/g/PhpGt/Cookie" target="_blank">
	<img src="https://badge.status.php.gt/cookie-quality.svg" alt="Code quality" />
</a>
<a href="https://scrutinizer-ci.com/g/PhpGt/Cookie" target="_blank">
	<img src="https://badge.status.php.gt/cookie-coverage.svg" alt="Code coverage" />
</a>
<a href="https://packagist.org/packages/PhpGt/Cookie" target="_blank">
	<img src="https://badge.status.php.gt/cookie-version.svg" alt="Current version" />
</a>
<a href="http://www.php.gt/cookie" target="_blank">
	<img src="https://badge.status.php.gt/cookie-docs.svg" alt="PHP.Gt/Cookie documentation" />
</a>

## Example usage

```php
// Create a replacement for $_COOKIE.
$cookie = new Gt\Cookie\CookieHandler($_COOKIE);

// Access values as normal.
$value = $cookie["firstVisit"];

if(isset($cookie["firstVisit"])) {
// Cookie "firstVisit" exists.
}

if($cookie->has("firstVisit")) {
// Cookie "firstVisit" exists.
}
else {
// Create a new cookie that expires in ten days.
	$now = new DateTime();
	$expire = new DateTime("+10 days");
	$cookie->set("firstVisit", $now, $expire);
}

// Now you can unset the superglobal!
```

## What's not covered?

This library does not touch on encrypting cookies. To store sensitive information across HTTP requests, use a session variable. To ensure cookies can't be read by JavaScript, use a secure HTTP-only cookie.
