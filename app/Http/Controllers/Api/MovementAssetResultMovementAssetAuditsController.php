<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\MovementAssetResult;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovementAssetAuditResource;
use App\Http\Resources\MovementAssetAuditCollection;

class MovementAssetResultMovementAssetAuditsController extends Controller
{
    public function index(
        Request $request,
        MovementAssetResult $movementAssetResult
    ): MovementAssetAuditCollection {
        $this->authorize('view', $movementAssetResult);

        $search = $request->get('search', '');

        $movementAssetAudits = $movementAssetResult
            ->movementAssetAudits()
            ->search($search)
            ->latest()
            ->paginate();

        return new MovementAssetAuditCollection($movementAssetAudits);
    }

    public function store(
        Request $request,
        MovementAssetResult $movementAssetResult
    ): MovementAssetAuditResource {
        $this->authorize('create', MovementAssetAudit::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'movement_asset_id' => ['required', 'exists:movement_assets,id'],
            'good_cond_qty' => ['required', 'numeric'],
            'bad_cond_qty' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $movementAssetAudit = $movementAssetResult
            ->movementAssetAudits()
            ->create($validated);

        return new MovementAssetAuditResource($movementAssetAudit);
    }
}
