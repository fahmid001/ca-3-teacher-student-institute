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
                                    <img src="{{ asset('frontend/noipunno/images/icons/linear-book.svg') }}" alt="">
                                </div>
                                <div class="content">
                                    <h2 class="title">সেকশন ব্যবস্থাপনা</h2>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb np-breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('home')}}">
                                                    <img src="{{ asset('frontend/noipunno/images/icons/home.svg') }}" alt="">
                                                    ড্যাশবোর্ড
                                                </a></li>
                                            <li class="breadcrumb-item active" aria-current="page">সেকশন ব্যবস্থাপনা</li>
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
                            <img src="{{ asset('frontend/noipunno/images/icons/3-dot-vertical.svg') }}" alt="">
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
            <section class="np-teacher-list mt-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="title mb-3">সেকশন লিস্ট</h2>
                        </div>

                        <div class="col-md-12">
                            <div class="card np-card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table np-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">সেকশনের নাম
                                                        {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                        alt=""></span> --}}
                                                    </th>
                                                    <th scope="col">সেকশনের বিস্তারিত তথ্য
                                                        {{-- <span
                                                                    class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                        alt=""></span> --}}
                                                    </th>
                                                    <th scope="col">সেকশনের সন
                                                        {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                        alt=""></span> --}}
                                                    </th>
                                                    <th scope="col">ক্লাস
                                                        {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                        alt=""></span> --}}
                                                    </th>
                                                    <th scope="col">শিফট
                                                        {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                        alt=""></span> --}}
                                                    </th>
                                                    <th scope="col">ভার্সন
                                                        {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                        alt=""></span> --}}
                                                    </th>
                                                    <th scope="col">ব্রাঞ্চ
                                                        {{-- <span class="icon"><img
                                                                        src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}"
                                                        alt=""></span> --}}
                                                    </th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sectionList as $section)
                                                <tr>
                                                    <td scope="row"><span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/user.svg') }}" alt=""></span>{{ @$section->section_name }}
                                                        </th>
                                                    <td scope="row">{{ @$section->section_details }}</th>
                                                    <td scope="row">{{ @$section->section_year }}</th>
                                                    <td scope="row">{{ @$section->class_id }}</th>
                                                    <td scope="row">{{ @$section->shift->shift_name }}</th>
                                                    <td scope="row">{{ @$section->version->version_name }}
                                                        </th>
                                                    <td scope="row">{{ @$section->branch->branch_name }}
                                                        </th>
                                                    <td scope="row">
                                                        <div class="action-content">
                                                            <!-- <h2 class="created-date">
                                                                            {{ date('j F, Y', strtotime(@$section->created_at)) }}
                                                                        </h2> -->
                                                            <a href="{{ route('noipunno.dashboard.section.edit', ['id' => @$section->uid]) }}" class="np-route">
                                                                <button class="btn np-edit-btn-small">
                                                                    <img src="{{ asset('frontend/noipunno/images/icons/edit-white.svg') }}" alt="">
                                                                </button>
                                                            </a>
                                                        </div>
                                                        </th>

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

<div>
    <div class="np-pagination-section d-flex justify-content-end align-items-center">
        <div class="np-select-page-number d-flex align-items-center">
            {{ $sectionList->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<h2 class="np-form-title mt-5">সেকশন যোগ করুন </h2>

<section class="section-teacher-add-form mt-3 np-input-form-bg mb-5">
    <form action="{{ route('noipunno.dashboard.section.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div>
                        <label for="beiin-psid" class="form-label">ব্রাঞ্চ</label>
                        <div class="input-group">
                            <select class="form-select np-teacher-input" id="branch1" aria-label="Default select example" name="branch_id">
                                <option value="">ব্রাঞ্চ নির্বাচন করুন</option>
                                @foreach ($branchList as $branch)
                                <option value="{{ @$branch->uid }}" {{ old('branch_id','') == @$branch->uid ? 'selected':'' }}>{{ @$branch->branch_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('branch_id'))
                        <small class="help-block form-text text-danger">{{ $errors->first('branch_id') }}</small>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div>
                        <label for="beiin-psid" class="form-label">ভার্সন</label>
                        <div class="input-group">
                            <select class="form-select np-teacher-input" id="version1" aria-label="Default select example" name="version_id">
                                <option value="">ভার্সন নির্বাচন করুন</option>
                                @foreach ($versionList as $version)
                                <option value="{{ @$version->uid }}" {{ old('version_id','') == @$version->uid ? 'selected':'' }}>
                                    {{ @$version->version_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('version_id'))
                        <small class="help-block form-text text-danger">{{ $errors->first('version_id') }}</small>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div>
                        <label for="beiin-psid" class="form-label">শিফট</label>
                        <div class="input-group">
                            <select class="form-select np-teacher-input" id="shift1" aria-label="Default select example" name="shift_id">
                                <option value="">শিফট নির্বাচন করুন</option>
                                @foreach ($shiftList as $shift)
                                <option value="{{ @$shift->uid }}" {{ old('shift_id','') == @$shift->uid ? 'selected':'' }}>{{ @$shift->shift_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('shift_id'))
                        <small class="help-block form-text text-danger">{{ $errors->first('shift_id') }}</small>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 mt-5">
                    <div>
                        <label for="beiin-psid" class="form-label">ক্লাস <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-select np-teacher-input" aria-label="Default select example" name="class_id">
                                <option value="">ক্লাস নির্বাচন করুন</option>
                                {{-- <option value="6">Six</option>
                                                    <option value="7">Seven</option> --}}
                                {{-- @foreach ($classList as $class)
                                                        <option value="{{ $class['uid'] }}">{{ $class['name_en'] }}
                                </option>
                                @endforeach --}}

                                @foreach(App\Helper\ClassEnum::values() as $key=>$value)
                                <option value="{{ $key }}" {{ old('class_id','') == @$key ? 'selected':'' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if ($errors->has('class_id'))
                    <small class="help-block form-text text-danger">{{ $errors->first('class_id') }}</small>
                    @endif
                </div>
                <div class="col-md-4 col-sm-12 mt-5">
                    <div>
                        <label for="beiin-psid" class="form-label">সেকশনের নাম <span class="text-danger">*</span></label>
                        <input type="text" class="form-control np-teacher-input" id="loginId" placeholder="সেকশনের নাম" name="section_name" value="{{ old('section_name','')}}">
                    </div>
                    @if ($errors->has('section_name'))
                    <small class="help-block form-text text-danger">{{ $errors->first('section_name') }}</small>
                    @endif
                </div>
                <div class="col-md-4 col-sm-12 mt-5">
                    <div>
                        <label for="beiin-psid" class="form-label">শিক্ষাবর্ষ <span class="text-danger">*</span></label>
                        {{-- <input type="number" class="form-control np-teacher-input" id="loginId"
                                                placeholder="শিক্ষাবর্ষ" name="section_year"> --}}
                        <select class="form-select np-teacher-input" aria-label="Default select example" name="section_year">
                            <option value="">শিক্ষাবর্ষ নির্বাচন করুন</option>
                            <option value="2023" {{ old('section_year','') == "2023" ? 'selected':'' }}>2023</option>
                            <option value="2024" {{ old('section_year','') == "2024" ? 'selected':'' }}>2024</option>
                        </select>
                    </div>
                    @if ($errors->has('section_year'))
                    <small class="help-block form-text text-danger">{{ $errors->first('section_year') }}</small>
                    @endif
                </div>
                <div class="col-md-4 col-sm-12 mt-5">
                    <div>
                        <label for="beiin-psid" class="form-label">সেকশনের বিস্তারিত তথ্য</label>
                        <input type="text" class="form-control np-teacher-input" id="loginId" placeholder="সেকশনের বিস্তারিত তথ্য" name="section_details" value="{{ old('section_details','')}}">
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex justify-content-start">
                <button type="submit" class="btn btn-primary np-btn-form-submit mt-3 d-flex align-items-center" style="width: fit-content;border: unset;column-gap: 10px;">তথ্য সংযোজন করুন <img src="{{ asset('frontend/noipunno/images/icons/arrow-right.svg') }}" alt=""></button>
            </div>
        </div>
    </form>
</section>
</div>
</div>
</div>
{{-- Form ends --}}
{{-- List starts --}}

{{-- List ends --}}

</div>

<script>
    function fetchDataForBranch(id) {
        $.ajax({
            url: '{{ route("student.getBranchData") }}',
            type: 'GET',
            data: {
                id: id,
                '_token': $('input[name="_token"]').val(),
            },
            success: function(data) {
                $('#version1').empty();
                $.each(data.versions, function(key, value) {
                    $('#version1').append('<option value="' + value.uid + '">' + value.version_name + '</option>');
                });
                $('#shift1').empty();
                $.each(data.shifts, function(key, value) {
                    $('#shift1').append('<option value="' + value.uid + '">' + value.shift_name + '</option>');
                });
            }
        }, "json");
    }

    function fetchDataForSection(id) {
        var branch_id = document.getElementById('branch1').value,
            version_id = document.getElementById('version1').value,
            shift_id = document.getElementById('shift1').value,
            class_id = id;
        $.ajax({
            url: '{{ route("student.getSectionData") }}',
            type: 'GET',
            data: {
                branch_id,
                version_id,
                shift_id,
                class_id,
                '_token': $('input[name="_token"]').val(),
            },
            success: function(data) {
                $('#section1').empty();
                $('#registration_year1').empty();
                $.each(data, function(key, value) {
                    $('#section1').append('<option value="' + value.uid + '">' + value.section_name + '</option>');
                    $('#registration_year1').val(value.section_year)
                });
            }
        }, "json");
    }

    function addEventListeners() {
        $('#branch1').on('change', (event) => {
            fetchDataForBranch(event.target.value);
        });
    }

    addEventListeners();

</script>
@endsection