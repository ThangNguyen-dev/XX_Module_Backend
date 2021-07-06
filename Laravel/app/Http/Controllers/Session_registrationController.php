<?php

namespace App\Http\Controllers;

use App\Session_registration;
use Illuminate\Http\Request;

class Session_registrationController extends Controller
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
     * @param  \App\Session_registration  $session_registration
     * @return \Illuminate\Http\Response
     */
    public function show(Session_registration $session_registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Session_registration  $session_registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Session_registration $session_registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Session_registration  $session_registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Session_registration $session_registration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session_registration  $session_registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session_registration $session_registration)
    {
        //
    }
}
