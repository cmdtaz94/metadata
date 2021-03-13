<?php

namespace Cmdtaz\Metadata\Http\Controllers\Metadata;

use App\Http\Controllers\Controller;
use Cmdtaz\Metadata\Models\Metadata;
use Cmdtaz\Metadata\Traits\MetadataTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MetadataDataController extends Controller
{
    use MetadataTrait;

    /**
     * Display a listing of the resource.
     *
     * @param $metadataName
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($metadataName)
    {
        $metadata = Metadata::all();

        return response()->json($this->getMetadataData($metadata, $metadataName), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Metadata $metadata
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Metadata $metadata)
    {
        return response()->json($this->storeMetadataData($request->all(), $metadata), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param $metadataName
     * @param $dataId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($metadataName, $dataId)
    {
        return response()->json($this->findData($metadataName, $dataId), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Metadata $metadata
     * @return \Illuminate\Http\Response
     */
    public function edit(Metadata $metadata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Metadata $metadata
     * @param $dataId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Metadata $metadata, $dataId)
    {
        return response()->json($this->updateMetadataData($request->all(), $metadata, $dataId), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Metadata $metadata
     * @param $dataId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Metadata $metadata, $dataId)
    {
        return response()->json($this->destroyMetadataData($metadata, $dataId), Response::HTTP_OK);
    }
}
