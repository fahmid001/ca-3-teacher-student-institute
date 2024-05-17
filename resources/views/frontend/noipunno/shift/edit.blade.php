@extends('frontend.layouts.noipunno')

@section('content')
    <div class="dashboard-section"> {{-- Top section starts --}}
        <section class="np-breadcumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card np-breadcrumbs-card">
                            <div class="card-body">
                                <div class="title-section">
                                    <div class="icon">
                                        <img src="{{ asset('frontend/noipunno/images/icons/linear-book.svg') }}"
                                            alt="">
                                    </div>
                                    <div class="content">
                                        <h2 class="title">শিফট ব্যবস্থাপনা</h2>
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb np-breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('home') }}">
                                                        <img src="{{ asset('frontend/noipunno/images/icons/home.svg') }}"
                                                            alt="">
                                                        ড্যাশবোর্ড
                                                    </a></li>
                                                <li class="breadcrumb-item active" aria-current="page">শিফট ব্যবস্থাপনা</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>
                                {{-- <div class="option-section">
                                    <div class="fav-icon">
                                        <img src="{{ asset('frontend/noipunno/images/icons/fav-start-icon.svg') }}"
                                            alt="">
                                    </div>
                                    <div class="dots-icon">
                                        <img src="{{ asset('frontend/noipunno/images/icons/3-dot-vertical.svg') }}"
                                            alt="">
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Top section ends --}}
        {{-- Form starts --}}
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{-- List starts --}}
                    <section class="np-teacher-list mt-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="title mb-3">শিফট লিস্ট</h2>
                                </div>

                                <div class="col-md-12">
                                    <div class="card np-card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table np-table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">শিফটের নাম
                                                                {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                            alt=""></span> --}}
                                                            </th>
                                                            <th scope="col">শিফটের বিস্তারিত তথ্য
                                                                {{-- <span
                                                                    class="icon"> <img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                            alt=""></span> --}}
                                                            </th>
                                                            <th scope="col">ব্রাঞ্চের নাম
                                                                {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                            alt=""></span> --}}
                                                            </th>
                                                            <th scope="col">শিফট শুরুর সময়
                                                                {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                            alt=""></span> --}}
                                                            </th>
                                                            <th scope="col">শিফট শেষ সময়
                                                                {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                            alt=""></span> --}}
                                                            </th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($shiftList as $shift)
                                                            <tr>
                                                                <td scope="row"><span class="icon"><img
                                                                            src="{{ asset('frontend/noipunno/images/icons/user.svg') }}"
                                                                            alt=""></span>{{ @$shift->shift_name }}
                                                                    </td>
                                                                    @if (@$shift->shift_details == 'co-education')
                                                                        <td scope="row">কো-এডুকেসন</td>
                                                                    @elseif (@$shift->shift_details == 'boys')
                                                                        <td scope="row">বালক</td>
                                                                    @elseif (@$shift->shift_details == 'girls')
                                                                        <td scope="row">বালিকা</td>
                                                                    @else
                                                                        <td scope="row"></td>
                                                                @endif

                                                        <td scope="row">{{ @$shift->branch->branch_name }}</td>
                                                        <td scope="row"><input type="time" value="{{ @$shift->shift_start_time }}" disabled style="background: #FFF; border: unset; color: #000;"/></td>
                                                        <td scope="row"><input type="time" value="{{ @$shift->shift_end_time }}" disabled style="background: #FFF; border: unset; color: #000;"/></td>
                                                            {{-- <td scope="row">{{ @$shift->eiin }}</td> --}}
                                                        <td scope="row">
                                                            <div class="action-content">
                                                                <!-- <h2 class="created-date">
                                                                                            {{ date('j F, Y', strtotime(@$shift->created_at)) }}
                                                                                        </h2> -->
                                                                <a href="{{ route('noipunno.dashboard.shift.edit', ['id' => @$shift->uid]) }}"
                                                                    class="np-route">
                                                                    <button class="btn np-edit-btn-small">
                                                                        <img src="{{ asset('frontend/noipunno/images/icons/edit-white.svg') }}"
                                                                            alt="">
                                                                    </button>
                                                                </a>
                                                            </div>
                                                            </td>

                                                            </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-12">
                        <div class="np-pagination-section d-flex justify-content-between align-items-center">
                            <div class="np-select-page-number d-flex align-items-center">
                                <select class="form-select" aria-label="Default select example">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>

                                <h2 class="showing">
                                    Rows Showing 1 to 10 of 100 entries
                                </h2>
                            </div>
                            <div class="pages">
                                <div class="export-types">
                                    <button class="np-btn np-btn-primary np-btn-with-icon">
                                        <img src="{{ asset('frontend/noipunno/images/icons/pdf-export-icon.svg') }}"
                            alt="">
                            PDF
                            </button>

                            <button class="np-btn np-btn-primary np-btn-with-icon">
                                <img src="{{ asset('frontend/noipunno/images/icons/export-excel-icon.svg') }}" alt="">
                                Excel
                            </button>
                        </div>

                        <nav aria-label="Page navigation example">
                            <ul class="np-pagination pagination justify-content-end">
                                <li class="page-item np-card">
                                    <a class="page-link" href="#"><img src="{{ asset('frontend/noipunno/images/icons/chevron-left.svg') }}" alt=""></a>
                                </li>
                                <li class="page-item np-card"><a class="page-link" href="#">1</a></li>
                                <li class="page-item np-card"><a class="page-link active" href="#">2</a>
                                </li>
                                <li class="page-item np-card"><a class="page-link" href="#">3</a></li>
                                <li class="page-item np-card">
                                    <a class="page-link" href="#">
                                        <img src="{{ asset('frontend/noipunno/images/icons/chevron-right.svg') }}" alt="">
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
            </div>
        </div> --}}
                            </div>
                        </div>
                    </section>
                    {{-- List ends --}}

                    <div>
                        <div class="np-pagination-section d-flex justify-content-end align-items-center">
                            <div class="np-select-page-number d-flex align-items-center">
                                {{ $shiftList->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                    <h2 class="np-form-title mt-3">শিফট তথ্য পরিবর্তন করুন </h2>

                    <section class="section-teacher-add-form mt-3 np-input-form-bg mb-5" id="edit-form">
                        <div class="container">
                            <form method="POST"
                                action="{{ route('noipunno.dashboard.shift.update', ['id' => $shiftData->uid]) }}"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <!-- <div>
                                        <label for="beiin-psid" class="form-label">শিফটের নাম <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control np-teacher-input" id="loginId" placeholder="শিফটের নাম" name="shift_name" value="{{ @$shiftData->shift_name }}">
                                    </div> -->
                                        <div>
                                            <label for="beiin-psid" class="form-label">শিফটের নাম <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="form-select np-teacher-input"
                                                    aria-label="Default select example" name="shift_name">
                                                    {{-- <option value="{{ @$shiftData->shift_name }}">
                                                        {{ @$shiftData->shift_name }}</option> --}}
                                                    <option value="প্রভাতি"
                                                        {{ old('shift_name',@$shiftData->shift_name) == 'প্রভাতি' ? 'selected' : '' }}>
                                                        প্রভাতি
                                                    </option>
                                                    <option value="দিবা"
                                                        {{ old('shift_name',@$shiftData->shift_name) == 'দিবা' ? 'selected' : '' }}>দিবা
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        @if ($errors->has('shift_name'))
                                            <small
                                                class="help-block form-text text-danger">{{ $errors->first('shift_name') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div>
                                            <label for="beiin-psid" class="form-label">শিফটের বিস্তারিত তথ্য</label>
                                            <select class="form-select np-teacher-input" aria-label="Default select example"
                                                name="shift_details">
                                                <option value="co-education"
                                                    {{ old('shift_details',@$shiftData->shift_details) == 'co-education' ? 'selected' : '' }}>
                                                    কো-এডুকেসন </option>
                                                <option value="girls"
                                                    {{ old('shift_details',@$shiftData->shift_details) == 'girls' ? 'selected' : '' }}>বালিকা
                                                </option>
                                                <option value="boys"
                                                    {{ old('shift_details',@$shiftData->shift_details) == 'boys' ? 'selected' : '' }}>বালক
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div>
                                            <label for="beiin-psid" class="form-label">ব্রাঞ্চ</label>
                                            <div class="input-group">
                                                <select class="form-select np-teacher-input"
                                                    aria-label="Default select example" name="branch_id">
                                                    <option value="">Please Select Branch</option>
                                                    @foreach ($branchList as $branch)
                                                        <option value="{{ @$branch->uid }}"
                                                            {{ old('branch_id',@$shiftData->branch_id) == @$branch->uid ? 'selected' : '' }}>
                                                            {{ @$branch->branch_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if ($errors->has('branch_id'))
                                            <small
                                                class="help-block form-text text-danger">{{ $errors->first('branch_id') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-sm-12 mt-5">
                                        <div>
                                            <label for="beiin-psid" class="form-label">শিফট শুরুর সময় <span
                                                    class="text-danger">*</span></label>
                                            <input type="time" class="form-control np-teacher-input np-time-picker"
                                                id="loginId" placeholder="শিফট শুরুর সময়" name="shift_start_time"
                                                value="{{ old('shift_start_time',@$shiftData->shift_start_time) }}">
                                        </div>
                                        @if ($errors->has('shift_start_time'))
                                            <small
                                                class="help-block form-text text-danger">{{ $errors->first('shift_start_time') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-sm-12 mt-5">
                                        <div>
                                            <label for="beiin-psid" class="form-label">শিফট শেষ সময় <span
                                                    class="text-danger">*</span></label>
                                            <input type="time" class="form-control np-teacher-input np-time-picker"
                                                id="loginId" placeholder="শিফট শেষ সময়" name="shift_end_time"
                                                value="{{ old('shift_end_time',@$shiftData->shift_end_time) }}">
                                        </div>
                                        @if ($errors->has('shift_end_time'))
                                            <small
                                                class="help-block form-text text-danger">{{ $errors->first('shift_end_time') }}</small>
                                        @endif
                                    </div>



                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 d-flex justify-content-start">
                                        <button type="submit"
                                            class="btn btn-primary np-btn-form-submit mt-3 d-flex align-items-center"
                                            style="width: fit-content;border: unset;column-gap: 10px;"> <a
                                                class="np-btn-cancel"
                                                href="{{ route('noipunno.dashboard.shift.add') }}">বাতিল করুন</a>
                                            <img src="{{ asset('frontend/noipunno/images/icons/arrow-right.svg') }}"
                                                alt=""></button>
                                        <button type="submit"
                                            class="btn btn-primary np-btn-form-submit mt-3 mx-5 d-flex align-items-center"
                                            style="width: fit-content;border: unset;column-gap: 10px;">তথ্য হালনাগদ করুন
                                            <img src="{{ asset('frontend/noipunno/images/icons/arrow-right.svg') }}"
                                                alt=""></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        {{-- Form ends --}}


    </div>

    <script>
        $(document).ready(function() {
            document.getElementById("edit-form").scrollIntoView({
                "behavior": "smooth"
            });
        });
    </script>
@endsection
