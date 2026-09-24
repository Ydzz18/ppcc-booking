<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Store a newly created client.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'residential_address' => ['required', 'string', 'max:255'],
            'tin' => ['required', 'string', 'max:255'],
            'tel_phone_number' => ['required', 'string', 'max:255'],
            'email_address' => ['required', 'email', 'max:255'],
            'id_presented' => ['required', 'string', 'max:255'],
            'fathers_name' => ['required', 'string', 'max:255'],
            'mothers_maiden_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'civil_status' => ['required', 'string', 'max:255'],
            'religion' => ['required', 'string', 'max:255'],
            'capitalization' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'business_registrations' => ['nullable', 'array'],
            'business_registrations.*' => ['string', 'max:255'],
            'additional_requirements' => ['nullable', 'array'],
            'additional_requirements.*' => ['string', 'max:255'],
        ]);

        Client::create($validated);

        return Redirect::route('settings.index', ['clients_page' => 1])->with('status', 'client-created');
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client): View
    {
        return view('clients.edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified client.
     */
    public function update(Request $request, Client $client): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'residential_address' => ['required', 'string', 'max:255'],
            'tin' => ['required', 'string', 'max:255'],
            'tel_phone_number' => ['required', 'string', 'max:255'],
            'email_address' => ['required', 'email', 'max:255'],
            'id_presented' => ['required', 'string', 'max:255'],
            'fathers_name' => ['required', 'string', 'max:255'],
            'mothers_maiden_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'civil_status' => ['required', 'string', 'max:255'],
            'religion' => ['required', 'string', 'max:255'],
            'capitalization' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'business_registrations' => ['nullable', 'array'],
            'business_registrations.*' => ['string', 'max:255'],
            'additional_requirements' => ['nullable', 'array'],
            'additional_requirements.*' => ['string', 'max:255'],
        ]);

        $client->update($validated);

        return Redirect::route('settings.index')->with('status', 'client-updated');
    }
}
