<?php

namespace App\Http\Controllers;

use App\Models\Sessions;
use App\Http\Requests\StoreSessionsRequest;
use App\Http\Requests\UpdateSessionsRequest;

class SessionsController extends Controller
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
     * @param  \App\Http\Requests\StoreSessionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSessionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sessions  $sessions
     * @return \Illuminate\Http\Response
     */
    public function show(Sessions $sessions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sessions  $sessions
     * @return \Illuminate\Http\Response
     */
    public function edit(Sessions $sessions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSessionsRequest  $request
     * @param  \App\Models\Sessions  $sessions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSessionsRequest $request, Sessions $sessions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sessions  $sessions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sessions $sessions)
    {
        //
    }
}
