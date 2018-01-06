<?php
/**
 * General Validator
 *
 * @by Malak Abu Hammad.
 */

/**
 * Class Validator
 */
class Validator
{
    const INTEGER_PATTERN = '/^(0|-?[1-9][0-9]*)$/';
    const ID_PATTERN = '/^[a-zA-Z0-9\-!?]*$/';
    const DECIMAL_PATTERN = '/^[0-9]+(\.[0-9]*)?$/';

    const BOOLEAN = 'boolean';
    const STRING = 'string';
    const INTEGER = 'integer';
    const DECIMAL = 'decimal';
    const ID = 'id';
    const POSITIVE_DECIMAL = 'positive_decimal';

    /**
     * @var array
     */
    private $errors;

    /**
     * @param string $attributeName
     * @param string $message
     */
    public function addError($attributeName, $message)
    {
        $this->errors[$attributeName][] = $message;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string[]
     */
    private function getValidTypes()
    {
        return [self::BOOLEAN, self::STRING, self::INTEGER, self::DECIMAL, self::ID, self::POSITIVE_DECIMAL,];
    }

    /**
     * @param string $attributeType
     * @return bool
     */
    private function isValidType($attributeType)
    {
        return is_string($attributeType) && in_array($attributeType, $this->getValidTypes());
    }

    /**
     * @param string $attributeName
     * @param string $attributeType
     * @param mixed $attributeValue
     *
     * @return bool
     * @throws Exception
     */
    public function validateAttribute($attributeName, $attributeType, $attributeValue)
    {
        if (!$this->isValidType($attributeType)) {
            throw new Exception('Invalid type.');
        }
        switch ($attributeType):
            case self::BOOLEAN: {
                if (!$this->validateBoolean($attributeValue)) {
                    $this->addError($attributeName, 'Invalid boolean value.');
                    return false;
                }
                break;
            }
            case self::STRING: {
                if (!is_string($attributeValue)) {
                    $this->addError($attributeName, 'Invalid string value.');
                    return false;
                }
                break;
            }
            case self::INTEGER: {
                if (!$this->validateInteger($attributeValue)) {
                    $this->addError($attributeName, 'Invalid integer value.');
                    return false;
                }
                break;
            }
            case self::POSITIVE_DECIMAL: {
                /**
                 * to do
                 */
                if (!$this->validatePositiveDecimal($attributeValue)) {
                    $this->addError($attributeName, 'Invalid positive value.');
                    return false;
                }
                break;
            }
            case self::ID: {
                if (!$this->validateId($attributeValue)) {
                    $this->addError($attributeName, 'Invalid Id value.');
                    return false;
                }
                break;
            }
        endswitch;
        return true;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function validateInteger($value)
    {
        if ((!is_string($value) && !is_integer($value)) || !preg_match(static::INTEGER_PATTERN, "$value")) {
            return false;
        }
        return true;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function validateId($value)
    {
        if (!is_string($value) || !preg_match(static::ID_PATTERN, "$value")) {
            return false;
        }
        return true;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function validatePositiveDecimal($value)
    {
        if ((!is_string($value) && !is_numeric($value)) || !preg_match(static::DECIMAL_PATTERN, "$value") || $value < 0) {
            return false;
        }
        return true;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function validateBoolean($value)
    {
        if (is_null(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
            return false;
        }
        return true;
    }
}