<?php

namespace Cmdtaz\Metadata\Http\Controllers\Metadata;

use App\Http\Controllers\Controller;
use Cmdtaz\Metadata\Models\Metadata;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MetadataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:metadata,name,NULL,id,deleted_at,NULL']);

        $metadata = Metadata::create([
            'name' => $request->name,
        ]);

        return response()->json($metadata, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Metadata $metadata
     * @return \Illuminate\Http\Response
     */
    public function show(Metadata $metadata)
    {
        //
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Metadata $metadata)
    {
        $this->validate($request, ['name' => "required|unique:metadata,name,$metadata->id,id,deleted_at,NULL",]);

        $metadata->update([
            'name' => $request->name,
        ]);

        return response()->json($metadata, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Metadata $metadata
     * @return \Illuminate\Http\Response
     */
    public function destroy(Metadata $metadata)
    {
        //
    }
}
