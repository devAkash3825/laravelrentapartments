<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;



// Modals
use App\Models\AdminDetail;
use App\Models\Source;
use App\Models\Login;

class RenterController extends Controller
{
    //

    public function create()
    {
        $data['agents']   = AdminDetail::all();
        $data['sources'] = Source::all();
        $data['pagetitle'] = "Add Renter";
        return view('admin.renter.addRenter', $data);
    }

    public function store(Request $request)
    {
        $request->all();
    }


    public function activeRenters(Request $request)
    {
        return view('admin.renter.activeRenter');
    }
    
    public function activeRentersList(Request $request)
    {
        $query = Login::query()
            ->where('user_type', 'C')
            ->where('Status', '1')
            ->with('renterinfo')
            ->orderBy('Id', 'desc') // Get latest data first
            ->select('Id', 'UserName', 'Status');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('Firstname', fn($row) => $row->renterinfo->Firstname ?? '-')
            ->addColumn('Lastname', fn($row) => $row->renterinfo->Lastname ?? '-')
            ->addColumn('probability', fn($row) => $row->renterinfo->probability ?? '-')
            ->addColumn('adminname', fn($row) => $row->renterinfo->adminname ?? '-')

            ->addColumn('status', function ($row) {
                return $row->Status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })

            ->addColumn('actions', function ($row) {
                return '
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-sm btn-primary btn-view" title="View Details" onclick="viewRenter(' . $row->Id . ')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-info btn-edit" title="Edit Renter" onclick="editRenter(' . $row->Id . ')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-delete" title="Delete Renter" data-id="' . $row->Id . '">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            ';
            })

            ->rawColumns(['status', 'actions'])
            ->make(true);
    }
}
