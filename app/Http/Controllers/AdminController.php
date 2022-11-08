<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('AdminMembers', [
            'members' => \App\Models\Members::paginate(7)->through(fn($member) => [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'date' => \Carbon\Carbon::parse($member->created_at)->format('d/m/Y'),
                'amount' => $member->subscriptions->first()->amount,
                'currency' => strtoupper($member->subscriptions->first()->currency),
                'status' => ucfirst($member->subscriptions->first()->status),
            ])
        ]);
    }

    public function show(Request $request, $id)
    {
        $member = Members::where('id', $id)->first();

        return Inertia::render('AdminShow', [
            'member' => [
                'id' => $id,
                'name' => $member->name,
                'email' => $member->email,
                'address' => [
                    'city' => $member->city,
                    'country' => $member->country,
                    'street' => $member->address,
                    'state' => $member->state,
                    'postal_code' => $member->postal_code
                ],
                'subscription' => [
                    'amount' => $member->subscriptions->first()->amount,
                    'currency' => $member->subscriptions->first()->currency,
                    'status' => ucfirst($member->subscriptions->first()->status),
                    'date' => \Carbon\Carbon::parse($member->created_at)->format('d/m/Y'),
                    'payment_method' => ucfirst($member->subscriptions->first()->payment_method),
                ],
            ],
        ]);
    }
}
