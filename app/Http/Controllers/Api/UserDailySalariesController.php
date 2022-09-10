<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySalaryResource;
use App\Http\Resources\DailySalaryCollection;

class UserDailySalariesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $dailySalaries = $user
            ->dailySalariesApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySalaryCollection($dailySalaries);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', DailySalary::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'status' => ['required', 'in:1,2,3,4'],
            'presence_id' => ['nullable', 'exists:presences,id'],
        ]);

        $dailySalary = $user->dailySalariesApproved()->create($validated);

        return new DailySalaryResource($dailySalary);
    }
}
