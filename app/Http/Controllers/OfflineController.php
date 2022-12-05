<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\Subscriptions;
use Illuminate\Http\Request;

class OfflineController extends Controller
{
    public function create(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'amount' => 'required|numeric',
            'currency' => 'required',
            'payment_method' => 'required',
            'state' => 'nullable',
        ]);

        $member = Members::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'address' => $attributes['address'],
            'country' => $attributes['country'],
            'city' => $attributes['amount'],
            'state' => $attributes['state'],
            'postal_code' => $attributes['postal_code'],
        ]);

        Subscriptions::create([
            'status' => 'active',
            'members_id' => $member->id,
            'currency' => $attributes['currency'],
            'amount' => $attributes['amount'],
            'payment_method' => $attributes['payment_method']
        ]);
    }

    public function update()
    {
    }
}
