@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark font-weight-bold">
                    MULTI-LISTING SERVICES (MLS) - LISTING UPLOADING
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('sales_agent.properties.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Image Upload --}}
                        <div class="form-group mb-3">
                            <label for="images" class="form-label">Image (max of 3 Photos, 2MB .JPEG each)</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple accept=".jpeg,.jpg">
                            @error('images')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                            <small class="form-text text-muted">You can upload up to 3 JPEG/JPG images.</small>
                        </div>

                        {{-- Property Type --}}
                        <div class="form-group mb-3">
                            <label for="property_type" class="form-label">Property Type</label>
                            <select class="form-control" id="property_type" name="property_type" required>
                                <option value="">Select Property Type</option>
                                <option value="House&Lot">House & Lot</option>
                                <option value="Lot Only">Lot Only</option>
                                <option value="Condo">Condo</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Townhouse">Townhouse</option>
                            </select>
                        </div>

                        {{-- ======================================================
                             DYNAMIC PROPERTY-TYPE SECTIONS
                           ====================================================== --}}


                        {{-- HOUSE & LOT + TOWNHOUSE --}}
                        <div class="type-section" id="type-house" style="display:none;">
                            <h5 class="mt-3">House Details</h5>

                            <div class="form-group mb-3">
                                <label>Lot Area (sqm)</label>
                                <input type="number" step="0.01" name="lot_area" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Floor Area (sqm)</label>
                                <input type="number" step="0.01" name="floor_area" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Bedrooms</label>
                                <input type="number" name="bedrooms" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Bathrooms</label>
                                <input type="number" name="bathrooms" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Carport</label>
                                <select name="carport" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">None</option>
                                    <option value="1">1 Carport</option>
                                    <option value="2">2 Carport</option>
                                </select>
                            </div>
                        </div>

                        {{-- LOT ONLY --}}
                        <div class="type-section" id="type-lot" style="display:none;">
                            <h5 class="mt-3">Lot Details</h5>

                            <div class="form-group mb-3">
                                <label>Lot Area (sqm)</label>
                                <input type="number" step="0.01" name="lot_area" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Lot Classification</label>
                                <select name="lot_classification" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Agricultural">Agricultural</option>
                                    <option value="Commercial">Commercial</option>
                                </select>
                            </div>
                        </div>

                        {{-- CONDO --}}
                        <div class="type-section" id="type-condo" style="display:none;">
                            <h5 class="mt-3">Condo Details</h5>

                            <div class="form-group mb-3">
                                <label>Unit Type</label>
                                <select name="unit_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Studio">Studio</option>
                                    <option value="1BR">1BR</option>
                                    <option value="2BR">2BR</option>
                                    <option value="Penthouse">Penthouse</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Floor Area (sqm)</label>
                                <input type="number" step="0.01" name="floor_area" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Parking Slot</label>
                                <select name="parking" class="form-control">
                                    <option value="">Select</option>
                                    <option value="None">None</option>
                                    <option value="1 Slot">1 Slot</option>
                                    <option value="2 Slots">2 Slots</option>
                                </select>
                            </div>
                        </div>

                        {{-- COMMERCIAL --}}
                        <div class="type-section" id="type-commercial" style="display:none;">
                            <h5 class="mt-3">Commercial Details</h5>

                            <div class="form-group mb-3">
                                <label>Commercial Type</label>
                                <select name="commercial_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Office">Office</option>
                                    <option value="Warehouse">Warehouse</option>
                                    <option value="Retail">Retail</option>
                                    <option value="Mixed Use">Mixed Use</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Floor Area (sqm)</label>
                                <input type="number" step="0.01" name="floor_area" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Monthly Income (Optional)</label>
                                <input type="number" step="0.01" name="monthly_income" class="form-control">
                            </div>
                        </div>

                        {{-- APARTMENT --}}
                        <div class="type-section" id="type-apartment" style="display:none;">
                            <h5 class="mt-3">Apartment Details</h5>

                            <div class="form-group mb-3">
                                <label>Total Units</label>
                                <input type="number" name="total_units" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Monthly Rental Income</label>
                                <input type="number" step="0.01" name="monthly_income" class="form-control">
                            </div>
                        </div>


                        {{-- ======================================================
                                EXISTING FIELDS BELOW (unchanged)
                           ====================================================== --}}

                        {{-- Listing Category --}}
                        <div class="form-group mb-3">
                            <label for="listing_category" class="form-label">Listing Category</label>
                            <select class="form-control" id="listing_category" name="listing_category" required>
                                <option value="">Select Listing Category</option>
                                <option value="Brokerage">Brokerage</option>
                                <option value="Rent">Rent</option>
                                <option value="Sale">Sale</option>
                            </select>
                        </div>

                        {{-- Property Details --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Property Details</label>
                            <textarea class="form-control" name="property_details" rows="3">{{ old('property_details') }}</textarea>
                        </div>

                        {{-- Location --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" name="location" required>
                        </div>

                        {{-- Description --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="5" required></textarea>
                        </div>

                        {{-- Selling Price --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Selling Price</label>
                            <input type="number" class="form-control" name="selling_price" step="0.01" required>
                        </div>

                        {{-- Commission Offered --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Commission Offered</label>
                            <input type="text" class="form-control" name="commission_offered" required>
                        </div>

                        {{-- Conditions --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Conditions</label>
                            <textarea class="form-control" name="conditions" rows="3"></textarea>
                        </div>

                        {{-- Listing Owner --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Listing Owner</label>
                            <input type="text" class="form-control" name="listing_owner" required>
                        </div>

                        {{-- Owner Contact --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Owner Contact Number</label>
                            <input type="text" class="form-control" name="owner_contact_number" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Submit Listing</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =============================
     JAVASCRIPT FOR DYNAMIC FIELDS
   ============================= --}}
<script>
document.getElementById('property_type').addEventListener('change', function () {
    let value = this.value;

    document.querySelectorAll('.type-section').forEach(div => div.style.display = 'none');

    if (value === 'House&Lot' || value === 'Townhouse') {
        document.getElementById('type-house').style.display = 'block';
    }
    if (value === 'Lot Only') {
        document.getElementById('type-lot').style.display = 'block';
    }
    if (value === 'Condo') {
        document.getElementById('type-condo').style.display = 'block';
    }
    if (value === 'Commercial') {
        document.getElementById('type-commercial').style.display = 'block';
    }
    if (value === 'Apartment') {
        document.getElementById('type-apartment').style.display = 'block';
    }
});
</script>

@endsection
