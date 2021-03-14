<?php


namespace Cmdtaz\Metadata\Traits;


use Carbon\Carbon;
use Cmdtaz\Metadata\Models\Metadata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait MetadataTrait
{

    /**
     * @param $metadataName
     * @param $dataId
     * @param bool $withTrashed
     * @param string $dataType
     * @return mixed|null
     */
    protected function findData($metadataName, $dataId, $withTrashed = false, $dataType = 'id')
    {
        $metadata = Metadata::all();
        $metadataData = $this->getMetadataData($metadata, $metadataName, $withTrashed);

        if (is_null($metadataData))
            return null;

        $dataKey = $metadataData->search(function ($item, $key) use ($dataId, $dataType) {
            return $item[$dataType] == $dataId;
        });

        if ($dataKey === false)
            return null;

        $foundedData = $metadataData->get($dataKey);
        $foundedData['keyInMetadataData'] = $dataKey;

        return $foundedData;
    }

    /**
     * @param array $data
     * @param Metadata $metadata
     * @return Metadata
     */
    protected function storeMetadataData(array $data, Metadata $metadata)
    {
        $data['id'] = (string)Str::uuid();
        $metadataData = $metadata->data;
        $metadataData[] = $data;

        $metadata->update(['data' => $metadataData]);
        return $metadata;
    }

    /**
     * @param array $data
     * @param Metadata $metadata
     * @param $dataId
     * @return bool|Metadata
     */
    protected function updateMetadataData(array $data, Metadata $metadata, $dataId)
    {
        $updatedData = $this->findData($metadata->name, $dataId);

        if (is_null($updatedData))
            return false;

        $data['id'] = $dataId;
        $metadataData = $metadata->data;
        $metadataData[$updatedData['keyInMetadataData']] = $data;

        $metadata->update(['data' => $metadataData]);
        return $metadata;
    }

    /**
     * @param Metadata $metadata
     * @param $dataId
     * @return bool|Metadata
     */
    protected function destroyMetadataData(Metadata $metadata, $dataId)
    {
        $updatedData = $this->findData($metadata->name, $dataId);

        if (is_null($updatedData))
            return false;

        $updatedData['deleted_at'] = Carbon::now()->format('Y-m-d H:i:s');

        $metadataData = $metadata->data;
        $metadataData[$updatedData['keyInMetadataData']] = Arr::except($updatedData, ['keyInMetadataData']);

        $metadata->update(['data' => $metadataData]);
        return $metadata;
    }


    /**
     * @param array $metadataAttributes
     * @param Model $model
     * @return Model
     */
    protected function metadataRelationship(array $metadataAttributes, Model $model)
    {
        foreach ($metadataAttributes as $attribute) {
            $model->{$attribute} = $this->findData($model->{$attribute}['metadataName'], $model->{$attribute}['dataId']);
        }
        return $model;
    }

    /**
     * @param Collection $metadata
     * @param $metadataName
     * @param bool $withTrashed
     * @return mixed
     */
    protected function getMetadataData(Collection $metadata, $metadataName, $withTrashed = false)
    {
        $metadataData = optional($metadata->where('name', $metadataName)->first())->data;

        if (is_null($metadataData))
            return null;

        $metadataDataCollection = collect($metadataData);

        if (!$withTrashed) {
            $metadataDataCollection = $metadataDataCollection->filter(function ($dataItem, $dataItemKey) {
                return !$this->isSoftDeleted($dataItem);
            });
        }

        return $metadataDataCollection;
    }

    /**
     * @param array $dataItem
     * @return bool
     */
    protected function isSoftDeleted(array $dataItem)
    {
        if (!array_key_exists('deleted_at', $dataItem))
            return false;

        return !is_null($dataItem['deleted_at']);
    }


}
