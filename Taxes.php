<?php
/**
 * Taxes entity class
 *
 * @by Malak Abu Hammad.
 */

require_once 'Validator.php';

/**
 * Class Taxes
 */
class Taxes
{
    public $id;
    public $name;
    public $rate;
    public $inclusion_type;
    public $is_custom_amount;
    public $applied_money;

    /**
     * @return array
     */
    private function rules()
    {
        return [
            'id' => 'id',
            'name' => 'string',
            'rate' => 'positive_decimal',
            'inclusion_type' => 'string',
            'is_custom_amount' => 'boolean',
        ];
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $attributeName => $attributeValue) {
            $this->$attributeName = $attributeValue;
        }
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $values = array();
        foreach ($this->getAttributesNames() as $name)
            $values[$name] = $this->$name;

        return $values;
    }

    /**
     * @return array
     */
    private function getAttributesNames()
    {
        return [
            'id',
            'name',
            'rate',
            'inclusion_type',
            'is_custom_amount',
        ];
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $rules = $this->rules();
        foreach ($this->getAttributes() as $attributeName => $attributeValue) {
            if (!$this->validateAttribute($attributeName, $rules[$attributeName], $attributeValue)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $attributeName
     * @param $attributeType
     * @param $attributeValue
     * @return bool
     */
    private function validateAttribute($attributeName, $attributeType, $attributeValue)
    {
        $validator = new Validator();
        try {
            if (!$validator->validateAttribute($attributeName, $attributeType, $attributeValue)) {
                printMessage("Invalid Data, errors are: [" . json_encode($validator->getErrors()) . ']');
                return false;
            }
        } catch (Exception $e) {
            printMessage("Error occurred: [" . $e->getMessage() . ']');
            return false;
        }
        return true;
    }
}