<?php

namespace EFW\Auth;

class Bcrypt {
	protected static $_saltPrefix = '2a';
	protected static $_defaultCost = 8;
	protected static $_saltLength = 22;

	public static function hash($string, $cost = null) {
		if (empty($cost)) {
			$cost = self::$_defaultCost;
		}
		// Salt
		$salt = self::generateRandomSalt();
		// Hash string
		$hashString = self::generateHashString((int)$cost, $salt);
		return crypt($string, $hashString);
	}

	public static function check($string, $hash) {
		return (crypt($string, $hash) === $hash);
	}

	public static function generateRandomSalt() {
		// Salt seed
		$seed = uniqid(mt_rand(), true);
		// Generate salt
		$salt = base64_encode($seed);
		$salt = str_replace('+', '.', $salt);
		return substr($salt, 0, self::$_saltLength);
	}

	private static function generateHashString($cost, $salt) {
		return sprintf('$%s$%02d$%s$', self::$_saltPrefix, $cost, $salt);
	}
}