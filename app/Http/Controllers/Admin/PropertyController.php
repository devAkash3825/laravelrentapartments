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
                $editUrl = route('admin.properties.edit', $row->Id);
                return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified property
     */
    public function edit($id)
    {
        $property = PropertyInfo::with([
            'additionalInfo',
            'floorPlans.category',
            'galleries.images',
            'city.state',
            'login'
        ])->findOrFail($id);

        // Get all floor plan categories for dropdown
        $floorPlanCategories = \App\Models\PropertyFloorPlanCategory::where('Status', '1')->get();
        
        // Get all states for dropdown
        $states = \App\Models\State::where('status', '1')->get();
        
        // Get cities based on property's state
        $cities = \App\Models\City::where('status', '1')->get();

        // Get all users for dropdown
        $users = \App\Models\Login::all();

        return view('admin.property.edit', compact('property', 'floorPlanCategories', 'states', 'cities', 'users'));
    }

    /**
     * Update main property details (Tab 1)
     */
    public function update(Request $request, $id)
    {
        $property = PropertyInfo::findOrFail($id);

        $validated = $request->validate([
            'UserId' => 'nullable|exists:login,Id',
            'PropertyName' => 'required|string|max:255',
            'Company' => 'nullable|string|max:100',
            'PropertyContact' => 'nullable|string|max:200',
            'Units' => 'nullable|integer',
            'Year' => 'nullable|integer|digits:4',
            'YearRemodel' => 'nullable|integer|digits:4',
            'Email' => 'nullable|email|max:50',
            'Address' => 'nullable|string|max:100',
            'CityId' => 'nullable|exists:city,Id',
            'ContactNo' => 'nullable|string|max:20',
            'Area' => 'nullable|string|max:30',
            'Zone' => 'nullable|string|max:255',
            'Zip' => 'nullable|string|max:10',
            'WebSite' => 'nullable|url|max:60',
            'Fax' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'officehour' => 'nullable|string',
            'Status' => 'nullable|in:0,1',
            'Featured' => 'nullable|in:0,1',
            'ActiveOnSearch' => 'nullable|in:0,1',
        ]);

        $validated['ModifiedOn'] = now();
        $property->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Main details updated successfully!'
        ]);
    }

    /**
     * Update general details (Tab 2)
     */
    public function updateGeneral(Request $request, $id)
    {
        $property = PropertyInfo::findOrFail($id);

        $validated = $request->validate([
            'PropertyFeatures' => 'nullable|string',
            'CommunityFeatures' => 'nullable|string',
            'Keyword' => 'nullable|string',
        ]);

        $validated['ModifiedOn'] = now();
        $property->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'General details updated successfully!'
        ]);
    }

    /**
     * Update additional info (Tab 3)
     */
    public function updateAdditional(Request $request, $id)
    {
        $property = PropertyInfo::findOrFail($id);

        $validated = $request->validate([
            'LeasingTerms' => 'nullable|string',
            'QualifiyingCriteria' => 'nullable|string',
            'Parking' => 'nullable|string',
            'PetPolicy' => 'nullable|string',
            'Pets' => 'nullable|string',
            'Neighborhood' => 'nullable|string',
            'Schools' => 'nullable|string',
            'drivedirection' => 'nullable|string',
        ]);

        $validated['ModifiedOn'] = now();

        // Update or create additional info
        $property->additionalInfo()->updateOrCreate(
            ['PropertyId' => $property->Id],
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => 'Additional details updated successfully!'
        ]);
    }

    /**
     * Store a new floor plan (Tab 4)
     */
    public function storeFloorPlan(Request $request, $id)
    {
        $property = PropertyInfo::findOrFail($id);

        $validated = $request->validate([
            'CategoryId' => 'required|exists:propertyfloorplancategory,Id',
            'PlanName' => 'nullable|string',
            'PlanType' => 'nullable|string',
            'Footage' => 'nullable|integer',
            'Price' => 'nullable|integer',
            'deposit' => 'nullable|string|max:255',
            'Comments' => 'nullable|string',
            'special' => 'nullable|string',
            'expiry_date' => 'nullable|string',
            'avail_date' => 'nullable|string',
            'isavailable' => 'nullable|boolean',
            'Available_Url' => 'nullable|url|max:255',
            'floorplan_link' => 'nullable|url|max:255',
            'FloorPlan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['PropertyId'] = $property->Id;
        $validated['CreatedOn'] = now();
        $validated['ModifiedOn'] = now();
        $validated['Status'] = '1';

        // Handle floor plan image upload
        if ($request->hasFile('FloorPlan')) {
            $file = $request->file('FloorPlan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/floorplans'), $filename);
            $validated['FloorPlan'] = $filename;
        }

        $floorPlan = \App\Models\PropertyFloorPlanDetail::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Floor plan added successfully!',
            'floorPlan' => $floorPlan->load('category')
        ]);
    }

    /**
     * Update a floor plan (Tab 4)
     */
    public function updateFloorPlan(Request $request, $id, $floorPlanId)
    {
        $property = PropertyInfo::findOrFail($id);
        $floorPlan = \App\Models\PropertyFloorPlanDetail::where('PropertyId', $property->Id)
            ->findOrFail($floorPlanId);

        $validated = $request->validate([
            'CategoryId' => 'required|exists:propertyfloorplancategory,Id',
            'PlanName' => 'nullable|string',
            'PlanType' => 'nullable|string',
            'Footage' => 'nullable|integer',
            'Price' => 'nullable|integer',
            'deposit' => 'nullable|string|max:255',
            'Comments' => 'nullable|string',
            'special' => 'nullable|string',
            'expiry_date' => 'nullable|string',
            'avail_date' => 'nullable|string',
            'isavailable' => 'nullable|boolean',
            'Available_Url' => 'nullable|url|max:255',
            'floorplan_link' => 'nullable|url|max:255',
            'FloorPlan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['ModifiedOn'] = now();

        // Handle floor plan image upload
        if ($request->hasFile('FloorPlan')) {
            // Delete old image
            if ($floorPlan->FloorPlan && file_exists(public_path('uploads/floorplans/' . $floorPlan->FloorPlan))) {
                unlink(public_path('uploads/floorplans/' . $floorPlan->FloorPlan));
            }

            $file = $request->file('FloorPlan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/floorplans'), $filename);
            $validated['FloorPlan'] = $filename;
        }

        $floorPlan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Floor plan updated successfully!',
            'floorPlan' => $floorPlan->load('category')
        ]);
    }

    /**
     * Delete a floor plan (Tab 4)
     */
    public function deleteFloorPlan($id, $floorPlanId)
    {
        $property = PropertyInfo::findOrFail($id);
        $floorPlan = \App\Models\PropertyFloorPlanDetail::where('PropertyId', $property->Id)
            ->findOrFail($floorPlanId);

        // Delete floor plan image
        if ($floorPlan->FloorPlan && file_exists(public_path('uploads/floorplans/' . $floorPlan->FloorPlan))) {
            unlink(public_path('uploads/floorplans/' . $floorPlan->FloorPlan));
        }

        $floorPlan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Floor plan deleted successfully!'
        ]);
    }

    /**
     * Store a new gallery/album (Tab 5)
     */
    public function storeGallery(Request $request, $id)
    {
        $property = PropertyInfo::findOrFail($id);

        $validated = $request->validate([
            'Title' => 'required|string',
            'Description' => 'nullable|string',
        ]);

        $validated['PropertyId'] = $property->Id;
        $validated['CreatedOn'] = now();
        $validated['ModifiedOn'] = now();
        $validated['Status'] = '1';

        $gallery = \App\Models\GalleryType::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Gallery created successfully!',
            'gallery' => $gallery
        ]);
    }

    /**
     * Upload images to a gallery (Tab 5)
     */
    public function uploadGalleryImage(Request $request, $galleryId)
    {
        $gallery = \App\Models\GalleryType::findOrFail($galleryId);

        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'ImageTitle' => 'nullable|string|max:255',
            'Description' => 'nullable|string',
            'display_in_gallery' => 'nullable|boolean',
        ]);

        $uploadedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/galleries'), $filename);

                $image = \App\Models\GalleryDetails::create([
                    'GalleryId' => $gallery->Id,
                    'ImageTitle' => $request->ImageTitle,
                    'Description' => $request->Description,
                    'ImageName' => $filename,
                    'DefaultImage' => '0',
                    'display_in_gallery' => $request->display_in_gallery ? '1' : '0',
                    'CreatedOn' => now(),
                    'ModifiedOn' => now(),
                    'Status' => '1'
                ]);

                $uploadedImages[] = $image;
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($uploadedImages) . ' image(s) uploaded successfully!',
            'images' => $uploadedImages
        ]);
    }

    /**
     * Delete a gallery image (Tab 5)
     */
    public function deleteGalleryImage($imageId)
    {
        $image = \App\Models\GalleryDetails::findOrFail($imageId);

        // Delete image file
        if ($image->ImageName && file_exists(public_path('uploads/galleries/' . $image->ImageName))) {
            unlink(public_path('uploads/galleries/' . $image->ImageName));
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully!'
        ]);
    }

    /**
     * Set default gallery image (Tab 5)
     */
    public function setDefaultImage($imageId)
    {
        $image = \App\Models\GalleryDetails::findOrFail($imageId);
        
        // Remove default from all images in this gallery
        \App\Models\GalleryDetails::where('GalleryId', $image->GalleryId)
            ->update(['DefaultImage' => '0']);

        // Set this image as default
        $image->update(['DefaultImage' => '1']);

        return response()->json([
            'success' => true,
            'message' => 'Default image set successfully!'
        ]);
    }
}
