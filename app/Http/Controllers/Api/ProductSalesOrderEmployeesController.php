<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrderEmployee;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderEmployeeCollection;

class ProductSalesOrderEmployeesController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): SalesOrderEmployeeCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $salesOrderEmployees = $product
            ->salesOrderEmployees()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderEmployeeCollection($salesOrderEmployees);
    }

    public function store(
        Request $request,
        Product $product,
        SalesOrderEmployee $salesOrderEmployee
    ): Response {
        $this->authorize('update', $product);

        $product
            ->salesOrderEmployees()
            ->syncWithoutDetaching([$salesOrderEmployee->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Product $product,
        SalesOrderEmployee $salesOrderEmployee
    ): Response {
        $this->authorize('update', $product);

        $product->salesOrderEmployees()->detach($salesOrderEmployee);

        return response()->noContent();
    }
}
