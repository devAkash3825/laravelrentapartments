<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyInfo;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PropertyController extends Controller
{
    //

    public function create()
    {

        return view('admin.property.addProperty');
    }

    public function store(Request $request)
    {
        $request->all();
    }

    public function activeRenters(Request $request)
    {
        return view('admin.renter.activeRenter');
    }

    public function index()
    {
        return view('admin.property.index');
    }

    public function search()
    {
        return view('admin.property.search');
    }

    public function datatable(Request $request)
    {
        $query = PropertyInfo::query()
            ->with(['city', 'state']);

        // 🔍 Filters
        if ($request->property_title) {
            $query->where('PropertyName', 'like', '%' . $request->property_title . '%');
        }

        if ($request->added_by) {
            $query->where('AddedBy', $request->added_by);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('created_at', [
                Carbon::createFromFormat('d-m-Y', $request->date_from)->startOfDay(),
                Carbon::createFromFormat('d-m-Y', $request->date_to)->endOfDay(),
            ]);
        }

        if ($request->state_id) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->area) {
            $query->where('Area', 'like', '%' . $request->area . '%');
        }

        if ($request->zip_code) {
            $query->where('ZipCode', $request->zip_code);
        }

        if ($request->managed_by) {
            $query->where('ManagedBy', $request->managed_by);
        }

        if ($request->price_from) {
            $query->where('Price', '>=', $request->price_from);
        }

        if ($request->price_to) {
            $query->where('Price', '<=', $request->price_to);
        }

        if ($request->bedrooms) {
            $query->where('Bedrooms', $request->bedrooms);
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('Status', $request->status);
        }

        if ($request->featured) {
            $query->where('is_featured', 1);
        }

        return datatables()->of($query)
            ->addColumn('city', fn($row) => $row->city->name ?? '-')
            ->addColumn('state', fn($row) => $row->state->name ?? '-')
            ->addColumn('price', fn($row) => '₹' . number_format($row->Price))
            ->addColumn('status', function ($row) {
                return $row->Status
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($row) {
                return '<a href="#" class="btn btn-sm btn-primary">View</a>';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }
}
