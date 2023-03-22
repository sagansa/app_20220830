<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\SalesOrderEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.sales_order_employees.index',
            compact('salesOrderEmployees', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('name', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.sales_order_employees.create',
            compact('stores', 'users')
        );
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
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileimage = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage);
            Image::make('storage/' . $fileimage)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $fileimage;
        }

        $validated['user_id'] = auth()->user()->id;

        $salesOrderEmployee = SalesOrderEmployee::create($validated);

        return redirect()
            ->route('sales-order-employees.edit', $salesOrderEmployee)
            ->withSuccess(__('crud.common.created'));
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

        return view(
            'app.sales_order_employees.show',
            compact('salesOrderEmployee')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderEmployee $salesOrderEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        SalesOrderEmployee $salesOrderEmployee
    ) {
        $this->authorize('update', $salesOrderEmployee);

        $stores = Store::orderBy('name', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.sales_order_employees.edit',
            compact('salesOrderEmployee', 'stores', 'users')
        );
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
            $file = $request->file('image');
            $salesOrderEmployee->delete_image();
            $extension = $file->getClientOriginalExtension();
            $file_image = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image);
            Image::make('storage/' . $file_image)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $file_image;
        }

        $salesOrderEmployee->update($validated);

        return redirect()
            ->route('sales-order-employees.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('sales-order-employees.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
