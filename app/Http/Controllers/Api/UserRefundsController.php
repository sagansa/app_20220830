<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RefundResource;
use App\Http\Resources\RefundCollection;

class UserRefundsController extends Controller
{
    public function index(Request $request, User $user): RefundCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $refunds = $user
            ->refunds()
            ->search($search)
            ->latest()
            ->paginate();

        return new RefundCollection($refunds);
    }

    public function store(Request $request, User $user): RefundResource
    {
        $this->authorize('create', Refund::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $refund = $user->refunds()->create($validated);

        return new RefundResource($refund);
    }
}
