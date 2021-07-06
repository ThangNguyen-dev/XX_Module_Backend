<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Campaign_ticket;
use Illuminate\Http\Request;

class Campaign_ticketController extends Controller
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
        return view('ticket.create', ['campaign' => $campaign]);
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
                'name' => 'required',
                'cost' => 'required',
            ]
        );

        $special_validity = null;

        if ($request->special_validity == 'amount') {
            $request->validate([
                'amount' => 'required',
            ]);
            $special_validity = Campaign_ticket::setSpecialValidity(
                [
                    'type' => $request->special_validity,
                    'value' => $request->amount,
                ]
            );
        }

        if ($request->special_validity == 'date') {
            $request->validate([
                'date' => 'required',
            ]);
            $special_validity = Campaign_ticket::setSpecialValidity(
                [
                    'type' => $request->special_validity,
                    'value' => $request->date,
                ]
            );
        }
        $data['special_validity'] = $special_validity;
        $data['campaign_id'] = $campaign->id;
        Campaign_ticket::create($data);
        return redirect()->route('campaign.show', $campaign->id)->with(['success' => 'Ticket successfully updated']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign_ticket  $campaign_ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign_ticket $campaign_ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign_ticket  $campaign_ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign_ticket $campaign_ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign_ticket  $campaign_ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign_ticket $campaign_ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign_ticket  $campaign_ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign_ticket $campaign_ticket)
    {
        //
    }
}
