<?php

namespace App\Http\Controllers;

use App\Models\prompts_metadata;
use App\Http\Requests\Storeprompts_metadataRequest;
use App\Http\Requests\Updateprompts_metadataRequest;

class PromptsMetadataController extends Controller
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
     * @param  \App\Http\Requests\Storeprompts_metadataRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeprompts_metadataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\prompts_metadata  $prompts_metadata
     * @return \Illuminate\Http\Response
     */
    public function show(prompts_metadata $prompts_metadata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\prompts_metadata  $prompts_metadata
     * @return \Illuminate\Http\Response
     */
    public function edit(prompts_metadata $prompts_metadata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateprompts_metadataRequest  $request
     * @param  \App\Models\prompts_metadata  $prompts_metadata
     * @return \Illuminate\Http\Response
     */
    public function update(Updateprompts_metadataRequest $request, prompts_metadata $prompts_metadata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\prompts_metadata  $prompts_metadata
     * @return \Illuminate\Http\Response
     */
    public function destroy(prompts_metadata $prompts_metadata)
    {
        //
    }
}
