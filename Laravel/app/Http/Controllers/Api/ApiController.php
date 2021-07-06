<?php

namespace App\Http\Controllers\Api;

use App\Campaign;
use App\Campaign_ticket;
use App\Citizent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaRS;
use App\Http\Resources\CampaignRS;
use App\Http\Resources\RegistrationRS;
use App\Http\Resources\TicketRS;
use App\Organizer;
use App\Registration;
use App\Session_registration;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function campaigns()
    {
        $campaign = Campaign::where('date', '>', '2019-08-15')->orderBy('date')->get();
        return response()->json([
            'campaigns' => CampaignRS::collection($campaign),
        ], 200);
    }

    public function detailCampaign($organizer_slug, $campaign_slug)
    {
        $organizer = Organizer::where('slug', $organizer_slug)->first();
        $campaign = Campaign::where('slug', $campaign_slug)->first();

        if (is_null($organizer)) {
            return response()->json([
                'message' => 'Organizer not found',
            ], 404);
        }
        if (is_null($campaign)) {
            return response()->json([
                'message' => 'Campaign not found',
            ], 404);
        }

        return response()->json([
            'id' => $campaign->id,
            'name' => $campaign->name,
            'slug' => $campaign->slug,
            'date' => $campaign->date,
            'areas' => AreaRS::collection($campaign->area),
            'tickets' => TicketRS::collection($campaign->ticket),
        ], 200);
    }

    public function login(Request $request)
    {
        $citizen = Citizent::where('lastname', $request->lastname)->where('registration_code', $request->registration_code)->first();
        if ($citizen) {
            $citizen['login_token'] = md5($citizen->username);
        } else {
            return response()->json(['message' => 'Invalid login'], 401);
        }
        $citizen->update();
        return response()->json([
            'firstname' => $citizen['firstname'],
            'lastname' => $citizen['lastname'],
            'username' => $citizen['username'],
            'email' => $citizen['email'],
            'token' => $citizen['login_token'],

        ], 200);
    }

    public function logout(Request $request)
    {
        $citizen = Citizent::where('login_token', $request->token)->first();
        if (is_null($citizen)) {
            return response()->json([
                'message' => 'Invalid token',
            ], 401);
        }
        $citizen['login_token'] = '';
        $citizen->update();
        return response()->json([
            'message' => 'Logout success'
        ], 200);
    }

    public function newRegistration($organizer_slug, $campaign_slug, Request $request)
    {
        $citizen = Citizent::where('login_token', $request->token)->first();
        if (is_null($citizen)) {
            return response()->json([
                'message' => 'User not logged in',
            ], 401);
        }

        $ticket = Campaign_ticket::where('id', $request->ticket_id)->first();
        $ticket->available();
        if (!$ticket->available) {
            return response()->json([
                'message' => 'Ticket is no longer available',
            ], 401);
        }

        $isAlReadyRegistration = Registration::where('citizen_id', $citizen->id)->where('ticket_id', $ticket->id)->first();

        if ($isAlReadyRegistration) {
            return response()->json([
                'message' => 'User already registered',
            ], 401);
        }

        $registrationTime = Carbon::now()->format('Y-m-d H:i:s');
        $registration = Registration::create([
            'citizen_id' => $citizen->id,
            'ticket_id' => $ticket->id,
            'registration_time' => $registrationTime,
        ]);

        if (!is_null($request->session_ids)) {
            foreach ($request->session_ids as $session_id) {
                Session_registration::create(
                    [
                        'registration_id' => $registration->id,
                        'session_id' => $session_id,
                    ]
                );
            }
        }
        return response()->json([
            'message' => 'Registration successful',
        ], 200);
    }

    public function getRegistration(Request $request)
    {
        $citizen = Citizent::where('login_token', $request->token)->first();

        if (!$citizen) {
            return response()->json([
                'message' => 'User not logged in',
            ], 401);
        }
        $registration = Registration::where('citizen_id', $citizen->id)->get();

        return response()->json([
            'registrations' => RegistrationRS::collection($registration),
        ], 200);
    }
}
