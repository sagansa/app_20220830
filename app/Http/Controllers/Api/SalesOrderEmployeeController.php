<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SalesOrderEmployee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SalesOrderEmployeeResource;
use App\Http\Resources\SalesOrderEmployeeCollection;
use App\Http\Requests\SalesOrderEmployeeStoreRequest;
use App\Http\Requests\SalesOrderEmployeeUpdateRequest;

class SalesOrderEmployeeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SalesOrderEmployee::class);

        $search = $request->get('search', '');

        $salesOrderEmployees = SalesOrderEmployee::search($search)
            ->latest()
            ->paginate();

        return new SalesOrderEmployeeCollection($salesOrderEmployees);
    }

    /**
     * @param \App\Http\Requests\SalesOrderEmployeeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesOrderEmployeeStoreRequest $request)
    {
        $this->authorize('create', SalesOrderEmployee::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderEmployee = SalesOrderEmployee::create($validated);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderEmployee $salesOrderEmployee
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        SalesOrderEmployee $salesOrderEmployee
    ) {
        $this->authorize('view', $salesOrderEmployee);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }

    /**
     * @param \App\Http\Requests\SalesOrderEmployeeUpdateRequest $request
     * @param \App\Models\SalesOrderEmployee $salesOrderEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(
        SalesOrderEmployeeUpdateRequest $request,
        SalesOrderEmployee $salesOrderEmployee
    ) {
        $this->authorize('update', $salesOrderEmployee);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($salesOrderEmployee->image) {
                Storage::delete($salesOrderEmployee->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderEmployee->update($validated);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderEmployee $salesOrderEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SalesOrderEmployee $salesOrderEmployee
    ) {
        $this->authorize('delete', $salesOrderEmployee);

        if ($salesOrderEmployee->image) {
            Storage::delete($salesOrderEmployee->image);
        }

        $salesOrderEmployee->delete();

        return response()->noContent();
    }
}
