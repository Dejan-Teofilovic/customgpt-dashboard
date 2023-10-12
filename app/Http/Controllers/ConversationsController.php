<?php

namespace App\Http\Controllers;

use App\Models\conversations;
use App\Http\Requests\StoreconversationsRequest;
use App\Http\Requests\UpdateconversationsRequest;

class ConversationsController extends Controller
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
     * @param  \App\Http\Requests\StoreconversationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreconversationsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\conversations  $conversations
     * @return \Illuminate\Http\Response
     */
    public function show(conversations $conversations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\conversations  $conversations
     * @return \Illuminate\Http\Response
     */
    public function edit(conversations $conversations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateconversationsRequest  $request
     * @param  \App\Models\conversations  $conversations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateconversationsRequest $request, conversations $conversations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\conversations  $conversations
     * @return \Illuminate\Http\Response
     */
    public function destroy(conversations $conversations)
    {
        //
    }
}
