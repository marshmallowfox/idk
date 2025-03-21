<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Guest;
use App\Services\PhoneService;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
class GuestController extends Controller
{
    protected PhoneService $phoneService;

    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    public function indexGuests(Request $request): Response
    {
        return response()->json(Guest::paginate($request->query('per_page', 10)));
    }

    public function createGuest(Request $request): Response
    {
        $validated = $this->validateRequest($request);
        $validated['phone'] = $this->phoneService->formatPhone($validated['phone']);

        if (($validated['country_id'] ?? null) === null) {
            $regionCode = $this->phoneService->getRegionCode($validated['phone']);
            if (!$regionCode) {
                throw ValidationException::withMessages(['phone' => 'Failed to determine the country from the phone number.']);
            }

            $validated['country_id'] = Country::where('code', $regionCode)->value('id');

            if (($validated['country_id'] ?? null) === null) {
                throw ValidationException::withMessages(['phone' => 'The country is not registered or is restricted in application.']);
            }
        }

        $guest = Guest::create($validated);
        return response()->json($guest, 201);
    }

    public function showGuest(Guest $guest): Response
    {
        return response()->json($guest);
    }

    public function updateGuest(Request $request, Guest $guest): Response
    {
        $validated = $this->validateRequest($request, $guest->id);
        $validated['phone'] = $this->phoneService->formatPhone($validated['phone']);

        $guest->update($validated);
        return response()->json($guest);
    }

    public function deleteGuest(Guest $guest): Response
    {
        $guest->delete();
        return response()->json([], 204);
    }

    private function validateRequest(Request $request, ?string $guestId = null): array
    {
        return $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:guests,email,' . ($guestId ?? 'NULL') . ',id',
            'phone'      => 'required|string|max:20|unique:guests,phone,' . ($guestId ?? 'NULL') . ',id',
            'country_id' => 'nullable|exists:countries,id',
        ]);
    }
}
