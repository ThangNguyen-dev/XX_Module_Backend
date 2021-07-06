<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
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
        $campaign = Campaign::where('organizer_id', Auth::user()->id)->get();
        return view('campaign.index', ['campaigns' => $campaign]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|regex:/[0-9A-Za-z\-]/',
            'date' => 'required',
        ], [
            'slug.regex' => 'Slug must not be empty and only contain a-z, 0-9 and \'-\'',
        ]);

        $isAlreadyUsed = Campaign::where('slug', $data['slug'])->first();
        if ($isAlreadyUsed) {
            return back()->withErrors(['slug' => 'Slug is already used'])->withInput();
        }
        $data['organizer_id'] = Auth::user()->id;
        $campaign = Campaign::create($data);
        return redirect()->route('campaign.show', $campaign->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        return view('campaign.detail', ['campaign' => $campaign]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        return view('campaign.edit', ['campaign' => $campaign]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|regex:/[0-9a-zA-Z\-]/',
            'date' => 'required',
        ], [
            'slug.regex' => 'Slug must not be empty and only contain a-z, 0-9 and \'-\'',
        ]);

        $isAlreadyUsed = Campaign::where('slug', $data['slug'])->where('id', '<>', $campaign->id)->first();
        if ($isAlreadyUsed) {
            return back()->withErrors(['slug' => 'Slug is already used'])->withInput();
        }

        $campaign->update($data);
        return redirect()->route('campaign.show', ['campaign' => $campaign])->with(['success' => 'Ticket successfully updated']);
    }

    public function report(Campaign $campaign)
    {
        $labels = array();
        $capacities = array();
        $vaccinator = array();
        $colors = array();
        $colors2 = array();

        // set data chart
        foreach ($campaign->place as $place) {
            foreach ($place->session as  $session) {
                array_push($vaccinator, $session->session_registration->count());
                array_push($labels, $session->title);
                array_push($capacities, $session->place->capacity);
            }
        }

        // set color to chart
        foreach ($capacities as $key => $capacity) {
            if ($vaccinator[$key] >= $capacity) {
                array_push($colors, 'rgb(255,0,0)');
                array_push($colors2, 'rgb(106,90,205)');
            } else {
                array_push($colors, 'rgb(255,255,0)');
                array_push($colors2, 'rgb(106,90,205)');
            }
        }

        $dataChart = [
            'labels' => json_encode($labels),
            'vaccinators' => json_encode($vaccinator),
            'capacities' => json_encode($capacities),
            'colors' => json_encode($colors),
            'colors2' => json_encode($colors2),
        ];

        return view('campaign.report', [
            'campaign' => $campaign,
            'dataChart' => $dataChart,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
