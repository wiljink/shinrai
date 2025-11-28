@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3 fw-bold">Edit Agent</h3>
    <p class="text-muted">(Admin / Sales Manager may edit, but Admin approval only)</p>

    <div class="card p-4">

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <h5 class="fw-bold mt-3">Agent Information</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>M.I.</label>
                    <input type="text" name="middle_initial" class="form-control" value="{{ old('middle_initial', $user->middle_initial) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Date of Birth</label>
                    <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $user->birthday) }}">
                </div>

                <div class="col-md-8 mb-3">
                    <label>Residence Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $user->contact_number) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>E-mail Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Emergency Contact Person</label>
                    <input type="text" name="emergency_person" class="form-control" value="{{ old('emergency_person', $user->emergency_person) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Emergency Contact Number</label>
                    <input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact', $user->emergency_contact) }}">
                </div>
            </div>

            <h5 class="fw-bold mt-4">Sales Accreditation</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Accreditation</label>
                    <select name="accreditation" class="form-select">
                        <option value="Broker" {{ old('accreditation', $user->accreditation) == 'Broker' ? 'selected' : '' }}>Broker</option>
                        <option value="Real Estate Salesperson" {{ old('accreditation', $user->accreditation) == 'Real Estate Salesperson' ? 'selected' : '' }}>Real Estate Salesperson</option>
                        <option value="N/A" {{ old('accreditation', $user->accreditation) == 'N/A' ? 'selected' : '' }}>N/A</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Accreditation No. (if applicable)</label>
                    <input type="text" name="accreditation_number" class="form-control" value="{{ old('accreditation_number', $user->accreditation_number) }}">
                </div>
            </div>

            <h5 class="fw-bold mt-4">Designation</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <select name="role" class="form-select">
                        @foreach($roles as $value => $label)
                            <option value="{{ $value }}" {{ old('role', $user->role) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h5 class="fw-bold mt-4">Branch</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <select name="branch_id" class="form-select">
                        <option value="">None</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h5 class="fw-bold mt-4">Commission Rate</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Project Selling</label>
                    <select name="project_commission" class="form-select">
                        <option {{ old('project_commission', $user->project_commission) == '4%' ? 'selected' : '' }}>4%</option>
                        <option {{ old('project_commission', $user->project_commission) == '3.75%' ? 'selected' : '' }}>3.75%</option>
                        <option {{ old('project_commission', $user->project_commission) == '3.5%' ? 'selected' : '' }}>3.5%</option>
                        <option {{ old('project_commission', $user->project_commission) == '3.25%' ? 'selected' : '' }}>3.25%</option>
                        <option {{ old('project_commission', $user->project_commission) == '3%' ? 'selected' : '' }}>3%</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Brokerage Selling</label>
                    <input class="form-control" value="{{ old('brokerage_commission', $user->brokerage_commission ?? '10%') }}" name="brokerage_commission" readonly>
                </div>
            </div>

            {{-- Optional: Password change --}}
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
            </div>

            <h5 class="fw-bold mt-4">Approval Status</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <select name="is_approved" class="form-select">
                        <option value="0" {{ old('is_approved', $user->is_approved) == 0 ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ old('is_approved', $user->is_approved) == 1 ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update Agent</button>

        </form>

    </div>

</div>
@endsection
