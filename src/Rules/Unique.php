<?php


namespace Cmdtaz\Metadata\Rules;


use Cmdtaz\Metadata\Models\Metadata;
use Cmdtaz\Metadata\Traits\MetadataTrait;
use Illuminate\Contracts\Validation\Rule;

class Unique implements Rule
{
    use MetadataTrait;

    private $metadataName;
    private $dataFieldName;
    /**
     * @var bool
     */
    private $updated;
    private $message;
    private $dataId;
    /**
     * @var bool
     */
    private $withTrashed;

    /**
     * Create a new rule instance.
     *
     * @param $metadataName
     * @param $dataFieldName
     * @param bool $withTrashed
     * @param bool $updated
     * @param $dataId
     */
    public function __construct($metadataName, $dataFieldName, $withTrashed = false, $updated = false, $dataId = NULL)
    {
        $this->metadataName = $metadataName;
        $this->dataFieldName = $dataFieldName;
        $this->updated = $updated;
        $this->dataId = $dataId;
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
        $metadata = Metadata::where('name', $this->metadataName)->first();

        if (is_null($metadata)) {
            $this->message = "metadata with name $this->metadataName does not exist";
            return false;
        }

        if (is_null($metadata->data)) {
            return true;
        }

        foreach ($metadata->data as $item) {

            if (!array_key_exists("$this->dataFieldName", $item)) {
                $this->message = "data have not a key like $this->dataFieldName";
                return false;
            }

            // Skip $item if we search non trashed values and is not softDeleted
            if ((!$this->withTrashed && !$this->isSoftDeleted($item)) || $this->withTrashed) {

                if (!$this->updated && $item[$this->dataFieldName] == $value) {
                    $this->message = "$value already taken";
                    return false;
                }

                if ($this->updated && $item[$this->dataFieldName] == $value && $item['id'] != $this->dataId) {
                    $this->message = "$value already taken";
                    return false;
                }

            }

        }

        return true;
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
