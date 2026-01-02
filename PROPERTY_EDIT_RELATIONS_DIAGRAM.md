# Property Edit - Database Relations & Data Flow

## 📊 Database Relations Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                         PROPERTYINFO                             │
│  (Main Property Table - Central Hub)                            │
│  ----------------------------------------------------------------│
│  Id (PK), PropertyName, Company, Address, CityId (FK),          │
│  Email, ContactNo, Units, Year, YearRemodel, latitude,          │
│  longitude, officehour, Status, Featured, ActiveOnSearch        │
└──────────┬──────────────┬────────────┬───────────┬──────────────┘
           │              │            │           │
           │              │            │           │
           ▼              ▼            ▼           ▼
    ┌──────────┐   ┌─────────┐  ┌──────────┐  ┌────────────┐
    │  LOGIN   │   │  CITY   │  │BILLCITY  │  │   STATE    │
    │ (User)   │   │         │  │(City FK) │  │            │
    └──────────┘   └─────────┘  └──────────┘  └────────────┘
                                                      ▲
                                                      │
                                                      │
                                          ┌───────────┴──────┐
                                          │    City.StateId  │
                                          └──────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│         PROPERTYINFO Relationships (1:1 and 1:Many)             │
└─────────────────────────────────────────────────────────────────┘

    PROPERTYINFO (1) ─────── (1) PROPERTYADDITIONALINFO
         │                            │
         │                            └── Fields: LeasingTerms,
         │                                QualifiyingCriteria, Parking,
         │                                PetPolicy, Neighborhood,
         │                                Schools, drivedirection
         │
         │
         ├─── (Many) PROPERTYFLOORPLANDETAILS
         │                │
         │                ├── CategoryId (FK) ──→ PROPERTYFLOORPLANCATEGORY
         │                │
         │                └── Fields: PlanName, PlanType, Footage,
         │                    Price, deposit, Comments, special,
         │                    expiry_date, avail_date, isavailable,
         │                    FloorPlan (image), floorplan_link
         │
         │
         └─── (Many) GALLERYTYPE
                      │
                      └── Fields: Title, Description
                           │
                           └─── (Many) GALLERYDETAILS
                                        │
                                        └── Fields: ImageTitle,
                                            Description, ImageName,
                                            DefaultImage,
                                            display_in_gallery,
                                            floorplan_id (FK - optional)
```

---

## 🔄 Data Flow in Edit Functionality

### Tab 1: Main Details Flow
```
User Form Input
      │
      ▼
JavaScript AJAX (mainDetailsForm.submit)
      │
      ▼
Route: PUT /admin/property/properties/{id}
      │
      ▼
PropertyController@update
      │
      ├─── Validation
      │
      ├─── Update PROPERTYINFO record
      │
      └─── Return JSON success
               │
               ▼
          Show Success Message
```

### Tab 2: General Details Flow
```
User Form Input (Summernote)
      │
      ▼
JavaScript AJAX (generalDetailsForm.submit)
      │
      ▼
Route: PUT /admin/property/properties/{id}/general
      │
      ▼
PropertyController@updateGeneral
      │
      ├─── Validation
      │
      ├─── Update PROPERTYINFO.PropertyFeatures
      ├─── Update PROPERTYINFO.CommunityFeatures
      ├─── Update PROPERTYINFO.Keyword
      │
      └─── Return JSON success
               │
               ▼
          Show Success Message
```

### Tab 3: Additional Details Flow
```
User Form Input (Summernote)
      │
      ▼
JavaScript AJAX (additionalDetailsForm.submit)
      │
      ▼
Route: PUT /admin/property/properties/{id}/additional
      │
      ▼
PropertyController@updateAdditional
      │
      ├─── Validation
      │
      ├─── Find Property
      │
      ├─── updateOrCreate PROPERTYADDITIONALINFO
      │     (Creates if doesn't exist, updates if exists)
      │
      └─── Return JSON success
               │
               ▼
          Show Success Message
```

### Tab 4: Floor Plans Flow (CRUD)

#### ADD Floor Plan:
```
User Fills Modal Form + Uploads Image
      │
      ▼
JavaScript AJAX (floorPlanForm.submit)
      │
      ▼
Route: POST /admin/property/properties/{id}/floorplans
      │
      ▼
PropertyController@storeFloorPlan
      │
      ├─── Validation
      │
      ├─── Upload FloorPlan image to /public/uploads/floorplans/
      │
      ├─── Create PROPERTYFLOORPLANDETAILS record
      │
      └─── Return JSON with new floor plan data
               │
               ▼
          Show Success + Reload Page
```

#### EDIT Floor Plan:
```
Click Edit Button
      │
      ▼
Populate Modal with Existing Data (data attributes)
      │
      ▼
User Edits + Submits
      │
      ▼
Route: PUT /admin/property/properties/{id}/floorplans/{floorPlanId}
      │
      ▼
PropertyController@updateFloorPlan
      │
      ├─── Validation
      │
      ├─── If new image: Delete old + Upload new
      │
      ├─── Update PROPERTYFLOORPLANDETAILS record
      │
      └─── Return JSON success
               │
               ▼
          Show Success + Reload Page
```

#### DELETE Floor Plan:
```
Click Delete Button
      │
      ▼
Confirm Dialog
      │
      ▼
Route: DELETE /admin/property/properties/{id}/floorplans/{floorPlanId}
      │
      ▼
PropertyController@deleteFloorPlan
      │
      ├─── Find Floor Plan
      │
      ├─── Delete image file from server
      │
      ├─── Delete PROPERTYFLOORPLANDETAILS record
      │
      └─── Return JSON success
               │
               ▼
          Remove row from table + Show Success
```

### Tab 5: Photo Gallery Flow (CRUD)

#### CREATE Gallery:
```
User Fills Gallery Form (Title + Description)
      │
      ▼
Route: POST /admin/property/properties/{id}/galleries
      │
      ▼
PropertyController@storeGallery
      │
      ├─── Validation
      │
      ├─── Create GALLERYTYPE record
      │
      └─── Return JSON with gallery data
               │
               ▼
          Show Success + Reload Page
```

#### UPLOAD Images:
```
User Selects Multiple Images + Clicks Upload
      │
      ▼
JavaScript: Show Preview
      │
      ▼
Route: POST /admin/property/galleries/{galleryId}/images
      │
      ▼
PropertyController@uploadGalleryImage
      │
      ├─── Validation (each image)
      │
      ├─── Loop through images:
      │     ├─── Upload to /public/uploads/galleries/
      │     └─── Create GALLERYDETAILS record
      │
      └─── Return JSON with uploaded images
               │
               ▼
          Show Success + Reload Page
```

#### SET DEFAULT Image:
```
Click Star Icon on Image
      │
      ▼
Route: PUT /admin/property/gallery-images/{imageId}/default
      │
      ▼
PropertyController@setDefaultImage
      │
      ├─── Find Image
      │
      ├─── Set all images in gallery DefaultImage = '0'
      │
      ├─── Set this image DefaultImage = '1'
      │
      └─── Return JSON success
               │
               ▼
          Show Success + Reload Page
```

#### DELETE Image:
```
Click Trash Icon on Image
      │
      ▼
Confirm Dialog
      │
      ▼
Route: DELETE /admin/property/gallery-images/{imageId}
      │
      ▼
PropertyController@deleteGalleryImage
      │
      ├─── Find Image
      │
      ├─── Delete image file from server
      │
      ├─── Delete GALLERYDETAILS record
      │
      └─── Return JSON success
               │
               ▼
          Remove image from grid + Show Success
```

---

## 🎯 Key Relationships Summary

| Parent Table | Relation | Child Table | Type | Foreign Key |
|--------------|----------|-------------|------|-------------|
| propertyinfo | → | login | Many-to-One | UserId |
| propertyinfo | → | city | Many-to-One | CityId |
| propertyinfo | → | city (billing) | Many-to-One | BillCity |
| propertyinfo | → | propertyadditionalinfo | One-to-One | PropertyId |
| propertyinfo | → | propertyfloorplandetails | One-to-Many | PropertyId |
| propertyinfo | → | gallerytype | One-to-Many | PropertyId |
| propertyfloorplandetails | → | propertyfloorplancategory | Many-to-One | CategoryId |
| gallerytype | → | gallerydetails | One-to-Many | GalleryId |
| gallerydetails | → | propertyfloorplandetails | Many-to-One (optional) | floorplan_id |
| city | → | state | Many-to-One | StateId |

---

## 🗂️ File Upload Locations

```
public/
  uploads/
    properties/          → Main property images (PictureName)
    floorplans/          → Floor plan images (FloorPlan)
    galleries/           → Gallery images (ImageName)
```

**Naming Convention:**
- Pattern: `{timestamp}_{original_filename}`
- Example: `1704212400_floorplan_2br.jpg`
- For galleries: `{timestamp}_{uniqid}.{extension}`

---

## 📋 Validation Rules Summary

### Main Details (Tab 1)
- **PropertyName:** Required, String, Max 255
- **Email:** Email format, Max 50
- **Year/YearRemodel:** Integer, 4 digits, 1900-current year
- **WebSite:** Valid URL, Max 60
- **Units:** Integer
- **Status/Featured/ActiveOnSearch:** Boolean (0 or 1)

### Floor Plans (Tab 4)
- **CategoryId:** Required, Exists in propertyfloorplancategory
- **Footage/Price:** Integer
- **FloorPlan:** Image, JPEG/PNG/GIF, Max 2MB
- **Available_Url/floorplan_link:** Valid URL

### Gallery Images (Tab 5)
- **images[]:** Required, Each must be image, JPEG/PNG/GIF, Max 2MB
- **Title:** String, Max 255
- **display_in_gallery:** Boolean

---

## 🔐 Security Features

1. **CSRF Protection:** All forms include `@csrf` token
2. **Authentication:** All routes protected by `auth:admin` middleware
3. **Validation:** Server-side validation on all inputs
4. **File Upload Security:**
   - File type validation (only images)
   - File size limits (2MB)
   - Unique filename generation
   - Server-side checks before saving

---

## 🎨 UI Component Hierarchy

```
edit.blade.php (Main Container)
│
├── Bootstrap Tabs Navigation
│   ├── Tab: Main Details
│   ├── Tab: General Details
│   ├── Tab: Additional Details
│   ├── Tab: Rent & Specials
│   └── Tab: Photos
│
├── Tab Content Area
│   ├── @include('admin.property.edit._tab_main_details')
│   ├── @include('admin.property.edit._tab_general_details')
│   ├── @include('admin.property.edit._tab_additional_details')
│   ├── @include('admin.property.edit._tab_floor_plans')
│   │   └── Modal: Add/Edit Floor Plan
│   └── @include('admin.property.edit._tab_photos')
│       ├── Modal: Add Gallery
│       └── Modal: Upload Images
│
└── Summernote Initialization
    └── Success/Error Handlers
```

---

**This diagram shows complete data flow and relationships!**
