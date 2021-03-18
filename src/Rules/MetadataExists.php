<?php

namespace Cmdtaz\Metadata\Rules;

use Cmdtaz\Metadata\Traits\MetadataTrait;
use Illuminate\Contracts\Validation\Rule;

class MetadataExists implements Rule
{
    use MetadataTrait;

    private $metadataName;
    /**
     * @var string
     */
    private $valueType;
    /**
     * @var bool
     */
    private $withTrashed;
    /**
     * @var string
     */
    private $message;

    /**
     * Create a new rule instance.
     *
     * @param $metadataName
     * @param bool $withTrashed
     * @param string $valueType
     */
    public function __construct($metadataName, $withTrashed = false, $valueType = 'id')
    {
        $this->metadataName = $metadataName;
        $this->valueType = $valueType;
        $this->withTrashed = $withTrashed;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->message = "The selected $attribute is invalid.";
        return !is_null($this->findData($this->metadataName, $value, $this->withTrashed, $this->valueType));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
