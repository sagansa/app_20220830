<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingCourierResource;
use App\Http\Resources\ClosingCourierCollection;

class UserClosingCouriersController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): ClosingCourierCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $closingCouriers = $user
            ->closingCouriersApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingCourierCollection($closingCouriers);
    }

    public function store(Request $request, User $user): ClosingCourierResource
    {
        $this->authorize('create', ClosingCourier::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'bank_id' => ['required', 'exists:banks,id'],
            'total_cash_to_transfer' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $closingCourier = $user->closingCouriersApproved()->create($validated);

        return new ClosingCourierResource($closingCourier);
    }
}
