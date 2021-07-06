<?php

namespace App\Http\Controllers;

use App\Citizent;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Citizent  $citizent
     * @return \Illuminate\Http\Response
     */
    public function show(Citizent $citizent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Citizent  $citizent
     * @return \Illuminate\Http\Response
     */
    public function edit(Citizent $citizent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Citizent  $citizent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Citizent $citizent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Citizent  $citizent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Citizent $citizent)
    {
        //
    }
}
