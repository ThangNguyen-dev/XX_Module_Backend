<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Session;
use Illuminate\Http\Request;
use Prophecy\Exception\Doubler\ReturnByReferenceException;

class SessionController extends Controller
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
    public function create(Campaign $campaign)
    {
        return view('sessions.create', ['campaign' => $campaign]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Campaign $campaign, Request $request)
    {
        $data = $request->validate(
            [
                'title' => 'required',
                'cost' => 'required',
                'start' => 'required',
                'end' => 'required',
                'description' => 'required',
            ]
        );
        $request->validate([
            'participant' => 'required',
        ]);
        $data['vaccinator'] = $request['participant'];
        $isTimeConflict = Session::isTimeConflict(
            [
                'start' => $data['start'],
                'end' => $data['end'],
            ],
            ''
        );
        if ($isTimeConflict) {
            return back()->withErrors(['time' => 'Places already booked during this time'])->withInput();
        }
        $session = Session::create($data);
        return redirect()->route('campaign.show', ['campaign' => $campaign->id])->with(['success' => 'Session successfully created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign, Session $session)
    {
        return view('sessions.edit', ['campaign' => $campaign, 'session' => $session]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Campaign $campaign, Request $request, Session $session)
    {
        $data = $request->validate(
            [
                'type' => 'required',
                'title' => 'required',
                'vaccinator' => 'required',
                'place_id' => 'required',
                'cost' => 'required',
                'start' => 'required',
                'end' => 'required',
                'description' => 'required',
            ]
        );

        if ($session->isTimeConflict(
            [
                'start' => $data['start'],
                'end' => $data['end'],
            ],
            $session->id
        )) {
            return back()->withErrors(['time' => 'Places already booked during this time'])->withInput();
        };
        $session->update($data);

        return redirect()->route('campaign.show', [$campaign->id])->with(['success' => 'Session successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }
}
