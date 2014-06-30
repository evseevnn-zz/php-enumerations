<?php
namespace Component\Enumerations;

/**
 * Abstract class for enumerations in php
 */
abstract class AbstractEnum {

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var mixed
	 */
	private $value;

	/**
	 * Cache
	 * @var array
	 */
	private static $enumerations;

	/**
	 * @param string $name
	 * @param mixed $value
	 */
	final private function __construct($name, $value) {
		$this->name = $name;
		$this->value = $value;
	}

	/**
	 * When referring to an unknown constant static checks with the name function and returns a value
	 * @param string $name
	 * @param array $arguments
	 * @return mixed|static
	 */
	public static function __callStatic($name, $arguments) {
		$calledClass = get_called_class();
		$value = constant("{$calledClass}::{$name}");

		if (is_null($value)) return $value;

		return isset(self::$enumerations[$calledClass][$name]) ?
			self::$enumerations[$calledClass][$name] :
			self::$enumerations[$calledClass][$name] = new static($name, $value);
	}

	/**
	 * Returns the name of the constant
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns the value of the constant
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Returns true if the digit is equal to the passed
	 * @param mixed|AbstractEnum $value
	 * @return bool
	 */
	public function isValue($value) {
		if ($value instanceof AbstractEnum) return $value->getValue() === $this->getValue();

		return $this->getValue() === $value;
	}
}