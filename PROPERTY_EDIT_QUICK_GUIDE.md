# Property Edit - Quick Reference Guide

## 🚀 How to Access

1. **From Admin Panel:**
   - Navigate to: `/admin/property/properties`
   - Click "Edit" button on any property

2. **Direct URL:**
   - `/admin/property/properties/{id}/edit`

---

## 📑 Tab Structure

### Tab 1: Main Details
**Purpose:** Basic property information

**Key Fields:**
- Property Name (required)
- Management Company
- Address, City, Area, Zip
- Contact information
- Year Built/Remodeled
- Latitude/Longitude
- Status flags (Active, Featured, Active on Search)

**Save:** Click "Save Main Details" button


### Tab 2: General Details
**Purpose:** Marketing content and features

**Key Fields:**
- Community Description (Summernote)
- Agent Comments (Summernote)
- Keywords (Summernote)

**Save:** Click "Save General Details" button


### Tab 3: Additional Details
**Purpose:** Policies and tenant information

**All fields use Summernote editor:**
- Leasing Terms
- Qualifying Criteria
- Parking Information
- Pet Policy
- Neighborhood Description
- Driving Directions

**Save:** Click "Save Additional Details" button


### Tab 4: Rent & Specials (Floor Plans)
**Purpose:** Manage rental units and pricing

**Actions:**
1. **Add Floor Plan:** Click "Add New Floor Plan" button
2. **Edit:** Click edit icon on any floor plan
3. **Delete:** Click trash icon (with confirmation)

**Floor Plan Fields:**
- Category (required) - e.g., 1BR, 2BR, Studio
- Plan Name, Plan Type
- Square Footage, Monthly Rent, Deposit
- Comments, Special Offers
- Expiry Date, Available Date
- Floor Plan Image Upload
- Available checkbox

**Note:** Changes reload the page to show updated data


### Tab 5: Photos
**Purpose:** Manage property images

**Actions:**
1. **Create Gallery:** Click "Add New Gallery/Album"
2. **Upload Images:** Click "Upload Images" for a gallery
3. **Set Default:** Click star icon on an image
4. **Delete Image:** Click trash icon (with confirmation)

**Gallery Features:**
- Multiple galleries per property
- Multiple images per gallery
- Image preview before upload
- Default image selection
- Display in gallery toggle

**Note:** Changes reload the page to show updated data

---

## 💡 Tips & Tricks

1. **Summernote Editors:**
   - Full rich text editing
   - Add links, lists, formatting
   - Use Code View for custom HTML

2. **Image Uploads:**
   - Accepted: JPEG, PNG, GIF
   - Max size: 2MB per image
   - Multiple upload supported

3. **Floor Plans:**
   - Organize by category first
   - Add special offers with expiry dates
   - Mark as available/unavailable

4. **Validation:**
   - Required fields marked with red *
   - Form validates before submission
   - Error messages shown on failure

---

## 🔧 Troubleshooting

**Problem:** Images not uploading
**Solution:** 
- Check file size (max 2MB)
- Verify file format (jpg, png, gif)
- Ensure upload directories exist with write permissions

**Problem:** Rich text not saving
**Solution:**
- Ensure Summernote is initialized
- Check browser console for errors
- Verify CSRF token is present

**Problem:** Changes not showing
**Solution:**
- Some tabs (Floor Plans, Photos) reload page after save
- Other tabs use AJAX - check for success message
- Clear browser cache if needed

---

## 📝 Helper Methods in Models

### PropertyInfo Model
```php
$property->getFullAddress()           // Full formatted address
$property->getCoordinates()           // ['lat' => x, 'lng' => y]
$property->hasFloorPlans()            // Boolean
$property->hasGallery()               // Boolean
$property->getPropertyImage()         // Main image URL
$property->activeGalleries()          // Active galleries relation
$property->availableFloorPlans()      // Available floor plans
```

### PropertyFloorPlanDetail Model
```php
$floorPlan->getFormattedPrice()       // "$1,200"
$floorPlan->getFormattedFootage()     // "850 sq ft"
$floorPlan->isExpired()               // Check if special expired
$floorPlan->hasSpecial()              // Has active special
$floorPlan->getFloorPlanImage()       // Floor plan image URL
```

### GalleryType Model
```php
$gallery->getImagesCount()            // Number of images
$gallery->hasImages()                 // Boolean
$gallery->activeImages()              // Active images relation
$gallery->galleryImages()             // Gallery display images
```

### GalleryDetails Model
```php
$image->getImageUrl()                 // Full image URL
$image->isDefault()                   // Is default image
$image->isDisplayInGallery()          // Display in gallery
```

---

## 🎯 Common Tasks

**Change Property Name:**
1. Go to Tab 1
2. Edit "Property Name" field
3. Click "Save Main Details"

**Add Floor Plan with Special:**
1. Go to Tab 4
2. Click "Add New Floor Plan"
3. Fill in details
4. Add special text and expiry date
5. Upload floor plan image (optional)
6. Click "Save Floor Plan"

**Create Photo Gallery:**
1. Go to Tab 5
2. Click "Add New Gallery/Album"
3. Enter title and description
4. Click "Create Gallery"
5. Click "Upload Images" on new gallery
6. Select multiple images
7. Click "Upload Images"

**Update Pet Policy:**
1. Go to Tab 3
2. Edit "Pet Policy" field (Summernote editor)
3. Click "Save Additional Details"

---

## ⚡ API Endpoints Reference

All endpoints require authentication (`auth:admin` middleware)

**Main Updates:**
- PUT `admin/property/properties/{id}` - Main details
- PUT `admin/property/properties/{id}/general` - General details
- PUT `admin/property/properties/{id}/additional` - Additional details

**Floor Plans:**
- POST `admin/property/properties/{id}/floorplans` - Create
- PUT `admin/property/properties/{id}/floorplans/{floorPlanId}` - Update
- DELETE `admin/property/properties/{id}/floorplans/{floorPlanId}` - Delete

**Galleries:**
- POST `admin/property/properties/{id}/galleries` - Create gallery
- POST `admin/property/galleries/{galleryId}/images` - Upload images
- DELETE `admin/property/gallery-images/{imageId}` - Delete image
- PUT `admin/property/gallery-images/{imageId}/default` - Set default

---

## 🎨 Customization

### Change Notification Style
Edit in `edit.blade.php`:
```javascript
window.showSuccess = function(message) {
    // Replace with toastr, SweetAlert, etc.
    alert(message);
};
```

### Add More Summernote Toolbar Options
Edit in `edit.blade.php`:
```javascript
$('.summernote').summernote({
    toolbar: [
        // Add more toolbar options
    ]
});
```

### Change Upload File Size Limit
Edit in controller validation:
```php
'FloorPlan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
```

---

## 📊 Database Tables Reference

**propertyinfo** - Main property data
**propertyadditionalinfo** - Additional details (1:1)
**propertyfloorplandetails** - Floor plans (1:Many)
**propertyfloorplancategory** - Floor plan categories
**gallerytype** - Photo galleries (1:Many)
**gallerydetails** - Gallery images (1:Many)

---

**Need help?** Check `PROPERTY_EDIT_IMPLEMENTATION.md` for full documentation!
