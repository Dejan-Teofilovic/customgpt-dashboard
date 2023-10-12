<?php

namespace App\Http\Controllers;

use App\Models\prompt_histories;
use App\Http\Requests\Storeprompt_historiesRequest;
use App\Http\Requests\Updateprompt_historiesRequest;

class PromptHistoriesController extends Controller
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
     * @param  \App\Http\Requests\Storeprompt_historiesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeprompt_historiesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\prompt_histories  $prompt_histories
     * @return \Illuminate\Http\Response
     */
    public function show(prompt_histories $prompt_histories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\prompt_histories  $prompt_histories
     * @return \Illuminate\Http\Response
     */
    public function edit(prompt_histories $prompt_histories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateprompt_historiesRequest  $request
     * @param  \App\Models\prompt_histories  $prompt_histories
     * @return \Illuminate\Http\Response
     */
    public function update(Updateprompt_historiesRequest $request, prompt_histories $prompt_histories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\prompt_histories  $prompt_histories
     * @return \Illuminate\Http\Response
     */
    public function destroy(prompt_histories $prompt_histories)
    {
        //
    }
}
