@extends('frontend.layouts.noipunno')

@section('content')

<div class="dashboard-section">
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
                                    <h2 class="title">শিক্ষক ব্যবস্থাপনা</h2>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb np-breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('home')}}">
                                                    <img src="{{ asset('frontend/noipunno/images/icons/home.svg') }}" alt="">
                                                    ড্যাশবোর্ড
                                                </a></li>
                                            <li class="breadcrumb-item active" aria-current="page">শিক্ষক ব্যবস্থাপনা</li>
                                        </ol>
                                    </nav>

                                </div>
                            </div>
                            <!-- <div class="option-section">
                                <div class="fav-icon">
                                    <img src="{{ asset('frontend/noipunno/images/icons/fav-start-icon.svg') }}" alt="">
                                </div>
                                <div class="dots-icon">
                                    <img src="{{ asset('frontend/noipunno/images/icons/3-dot-vertical.svg') }}" alt="">
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- teacher add  -->
                <!-- search BEIIN/PSID -->
                <section class="section-teacher-add-form mt-5">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>{{ @$institute->institute_name ?? @$emisTeachers[0]->institutename }}</h5>
                            <a class="np-route" href="#addTeacher"><p class="btn np-btn-form-submit border-0 rounded-1"><i class="fa-solid fa-circle-plus"></i> শিক্ষক যুক্ত করুন ( PDS ধারী / PDS বিহীন )</p></a>
                        </div>
                    </div>
                </section>
                <!-- teacher add -->
                <section class="np-teacher-add-form">
                    <section class="np-teacher-list mt-5">
                        <div class="container">
                            <div class="row ">
                                <div class="col-md-12 mb-3">
                                    <h2 class="title">শিক্ষকের তালিকা (মোট: {{ count($myTeachers) }})</h2>
                                </div>

                                <div class="col-md-12">
                                    <div class="card np-card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table np-table" id="n_dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">শিক্ষকের নাম
                                                                {{-- <span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}" alt=""></span> --}}
                                                            </th>
                                                            <th scope="col">পদবি
                                                                {{-- <span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}" alt=""></span> --}}
                                                            </th>
                                                            <th scope="col">ফোন নম্বর
                                                                {{-- <span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}" alt=""></span> --}}
                                                            </th>
                                                            {{-- <th scope="col">ইমেইল আইডি</th> --}}
                                                            <th scope="col">PDS ID / ID
                                                                {{-- <span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}" alt=""></span> --}}
                                                            </th>
                                                            {{-- <th scope="col">একাউন্ট এর বর্তমান অবস্থা <span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}" alt=""></span></th> --}}
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($myTeachers as $teacher)
                                                        <tr>
                                                            <td scope="row"><span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/user.svg') }}" alt=""></span>{{ @$teacher->name_bn ?? @$teacher->name_en }}</th>
                                                            <td scope="row">{{@$teacher->designations->designation_name ?? @$teacher->designation}}</th>
                                                            <td scope="row">{{@$teacher->mobile_no}}</th>
                                                            {{-- <td scope="row">{{@$teacher->email}}</th> --}}
                                                            <td scope="row">{{@$teacher->pdsid ?? @$teacher->index_number ?? $teacher->caid}}</th>
                                                            {{-- <td scope="row">{{@$teacher->isactive == 1 ? 'সক্রিয়' : 'সক্রিয় নয়'}}</th> --}}
                                                            <td scope="row">
                                                                <div class="action-content">
                                                                    <!-- <h2 class="created-date">{{ date('j F, Y', strtotime(@$teacher->created_at)) }}</h2> -->
                                                                    @if($teacher->uid)
                                                                    <a href="{{ route('teacher.edit',@$teacher->uid) }}" class="np-route">
                                                                        <button class="btn np-edit-btn-small">
                                                                            <img src="{{ asset('frontend/noipunno/images/icons/edit-white.svg') }}" alt="">
                                                                        </button>
                                                                    </a>
                                                                    @if ($teacher->caid != auth()->user()->caid)
                                                                    <a class="btn np-delete-btn-small" id="delete"
                                                                            title="Delete" data-id="{{ $teacher->uid }}"
                                                                            data-token={{ csrf_token() }}
                                                                            data-route="{{ route('teacher.delete') }}">
                                                                            <i  class="fa fa-trash np-delete-btn-small-icon"></i></a>
                                                                    @endif
                                                                    {{-- <img src="{{ asset('frontend/noipunno/images/icons/3-dots-horizontal.svg') }}" alt=""> --}}
                                                                    @endif
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
                                                    <img src="{{ asset('frontend/noipunno/images/icons/pdf-export-icon.svg') }}" alt="">
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
                                                    <li class="page-item np-card"><a class="page-link active" href="#">2</a></li>
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
                    <div class="np-teacher-list row my-3">
                        <div class="col-md-7">
                            <h2 class="title">শিক্ষক যুক্ত করুন </h2>
                        </div>
                    </div>
                    <div class="np-input-form-bg mt-3" id="addTeacher">
                        <div class="container">

                            <form method="POST" action="{{ route("teacher.store") }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="loginId" class="form-label">শিক্ষকের Login ID (System auto generated)</label>
                                            <input type="text" class="form-control np-teacher-input" id="loginId" readonly>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="teacherName" class="form-label">শিক্ষকের নাম <span class="error">*</span></label>
                                            <input type="text" name="name_en" class="form-control np-teacher-input" id="teacherName" value="{{old('name_en')}}">
                                            @if($errors->has('name_en'))
                                            <div class="text-danger">
                                                {{ $errors->first('name_en') }}
                                            </div>
                                            @endif
                                        </div>

                                    </div>
                                    <!-- <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="pdsid" class="form-label">শিক্ষকের PDSID (যদি থাকে)</label>
                                            <input type="number" name="pdsid" class="form-control np-teacher-input" id="pdsid" value="{{old('pdsid')}}">
                                        </div>
                                        @if($errors->has('psid'))
                                            <div class="text-danger">
                                                {{ $errors->first('psid') }}
                                            </div>
                                        @endif
                                    </div> -->
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="teacherDesignation" class="form-label">শিক্ষকের পদবি <span class="error">*</span></label>
                                            {{-- <input type="text" name="designation" class="form-control np-teacher-input" id="teacherDesignation"> --}}
                                            <div class="input-group">
                                                <select class="form-select np-teacher-input" aria-label="Default select example" name="designation" id="teacherDesignation">
                                                    <option value="">শিক্ষকের পদবি নির্বাচন করুন</option>
                                                    @foreach ($designations as $designation)
                                                    <option value="{{ $designation->uid }}" @if(old("designation")==$designation->uid) selected @endif>{{ $designation->designation_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if($errors->has('designation'))
                                            <div class="text-danger">
                                                {{ $errors->first('designation') }}
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="teacherPhone" class="form-label">শিক্ষকের ফোন নম্বর</label>
                                            <input type="number" name="mobile_no" class="form-control np-teacher-input" id="teacherPhone" value="{{old('mobile_no')}}">
                                            @if($errors->has('mobile_no'))
                                            <div class="text-danger">
                                                {{ $errors->first('mobile_no') }}
                                            </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="teacherEmail" class="form-label">ইমেইল আইডি</label>
                                            <input type="email" name="email" class="form-control np-teacher-input" id="teacherEmail" value="{{old('email')}}">
                                        </div>
                                        @if($errors->has('email'))
                                            <div class="text-danger">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="teacherNid" class="form-label">এনআইডি</label>
                                            <input type="number" name="nid" class="form-control np-teacher-input" id="teacherNid" value="{{old('nid')}}">
                                        </div>
                                        @if($errors->has('nid'))
                                            <div class="text-danger">
                                                {{ $errors->first('nid') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div  class="mb-3">
                                            <label for="teacher_type" class="form-label">শিক্ষকের ধরন <span class="error">*</span></label>
                                            <div class="input-group">
                                                <select class="form-select np-teacher-input" aria-label="Default select example" name="teacher_type" id="teacher_type">
                                                    <option value="">শিক্ষকের ধরন নির্বাচন করুন</option>
                                                    <option value="1" @if(old("teacher_type")==1) selected @endif>PDS ধারী নিয়মিত শিক্ষক</option>
                                                    <option value="2" @if(old("teacher_type")==2) selected @endif>PDS বিহীন নিয়মিত শিক্ষক</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('teacher_type'))
                                            <small class="help-block form-text text-danger">{{ $errors->first('teacher_type') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div  class="mb-3">
                                            <label for="access_type" class="form-label">অ্যাক্সেসের ধরন <span class="error">*</span></label>
                                            <div class="input-group">
                                                <select class="form-select np-teacher-input mutiple-select2" aria-label="Default select example" name="access_type[]" id="access_type"
                                                multiple="multiple"
                                                >
                                                    {{-- <option value="">অ্যাক্সেসের ধরন নির্বাচন করুন</option> --}}
                                                    <option value="1" @if(is_array(old('access_type')) && in_array('1', old('access_type'))) selected @endif>সহকারী প্রধান শিক্ষক</option>
                                                    <option value="2" @if(is_array(old('access_type')) && in_array('2', old('access_type'))) selected @endif>শ্রেণী শিক্ষক</option>
                                                    <option value="3" @if(is_array(old('access_type')) && in_array('3', old('access_type'))) selected @endif>বিষয় শিক্ষক</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('access_type'))
                                            <small class="help-block form-text text-danger">{{ $errors->first('access_type') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="division_id" class="form-label">বিভাগ</label>
                                            <div class="input-group">
                                                <select class="form-select np-teacher-input" aria-label="Default select example" name="division_id" id="division_id">
                                                    <option value="">বিভাগ নির্বাচন করুন</option>
                                                    @foreach ($divisions as $division)
                                                    <option value="{{ $division->uid }}"  @if(old("division_id")==$division->uid) selected @endif>{{ $division->division_name_bn ?? $division->division_name_en }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('division_id'))
                                            <small class="help-block form-text text-danger">{{ $errors->first('division_id') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="district_id" class="form-label">জেলা</label>
                                            <div class="input-group">
                                                <select class="form-select np-teacher-input" aria-label="Default select example" name="district_id" id="district_id">
                                                    <option value="">জেলা নির্বাচন করুন</option>
                                                    @foreach ($districts as $district)
                                                    <option class="district-option division-{{$district->division_id}}" value="{{ $district->district_id }}" @if(old("district_id")==$district->district_id) selected @endif>{{ $district->district_name_bn ?? $district->district_name_en }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('district_id'))
                                            <small class="help-block form-text text-danger">{{ $errors->first('district_id') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="upazila_id" class="form-label">উপজেলা</label>
                                            <div class="input-group">
                                            <select class="form-select np-teacher-input" aria-label="Default select example" name="upazila_id" id="upazila_id">
                                                <option value="">উপজেলা নির্বাচন করুন</option>
                                                @foreach ($upazilas as $upazila)
                                                <option class="upazila-option district-{{$upazila->district_id}}" value="{{ $upazila->uid }}" @if(old("upazila_id")==$upazila->uid) selected @endif>{{ $upazila->upazila_name_bn ?? $upazila->upazila_name_en }}
                                                </option>
                                                @endforeach
                                            </select>
                                            </div>
                                            @if ($errors->has('upazila_id'))
                                            <small class="help-block form-text text-danger">{{ $errors->first('upazila_id') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="teacherImage" class="form-label">শিক্ষকের ছবি আপলোড করুন</label>
                                            <input type="file" name="image" class="form-control np-teacher-input" id="teacherImage">
                                        </div>
                                        @if($errors->has('image'))
                                            <div class="text-danger">
                                                {{ $errors->first('image') }}
                                            </div>
                                        @endif
                                    </div>  -->

                                </div>
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4 col-sm-12">
                                        <button type="submit" class="btn btn-primary np-btn-form-submit mt-3">তথ্য সংযোজন করুন <img src="{{ asset('frontend/noipunno/images/icons/arrow-right.svg') }}" alt="logo"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

                {{-- <div>
                    <div class="np-pagination-section d-flex justify-content-end align-items-center">
                        <div class="np-select-page-number d-flex align-items-center">
                            {{ $myTeachers->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div> --}}

                <!-- end teacher add  -->
            </div>
            <!-- teacher profile card -->
            <div class="col-md-4">
                <div class="container">
                    <div class="np-profile-card-header mt-5" style="height: 500px;overflow-y: auto;">
                        {{-- <h5 class="mb-3">{{ @$institute->institute_name ?? @$emisTeachers[0]->institutename }}</h5> --}}
                        <h6 class="mb-3">ব্যানবেইস / eMIS একাউন্ট এর তথ্য</h6>
                        {{-- <small>ব্যানবেইস / eMIS একাউন্ট এর তথ্য</small> --}}

                        <div class="col-md-12 mb-3">
                                    <small class="title">শিক্ষকের তালিকা (মোট: {{ count($emisTeachers) }})</small>
                                </div>
                        <!-- card -->

                        <form method="GET" action="{{ url()->full() }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row np-input-form-bg mt-2">
                                <div class="col-md-12 col-sm-12">
                                    <div>
                                        <label for="beiin-psid" class="form-label">তালিকায় না থাকা শিক্ষকের পিডিএস আইডি দিয়ে খুঁজুন।</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control np-teacher-input" id="searchInput" name="eiin_pdsid" placeholder="201395984..">
                                            <span class="search-icon">
                                                <span> <img src="{{ asset('frontend/noipunno/images/icons/close-red.svg') }}" class="np-search-field-icon clear-search" alt="logo"></span>
                                            </span>

                                        </div>
                                        <div id="suggestedResults" class="list-group np-search-suggesition-list"></div>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <div class="loading-data" style="display: none;">
                            <p>Data Searching....Please wait</p>
                        </div>

                        <div class="pdsid-teacher-search-result"></div>

                        <div class="teacher-data-list">
                            @foreach(@$emisTeachers as $teacher)
                            @if($teacher->pdsid)
                            <a href="{{ route('teacher.fromEmis',@$teacher->pdsid) }}" class="np-route">
                                <div class="card np-card np-profile-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto np-card-image">
                                                <img src="{{ asset('frontend/noipunno/images/avatar/teacher.png') }}" alt="Profile Image" class="rounded-circle" width="50">
                                            </div>
                                            <div class="col np-card-details">
                                                <p class="np-card-title">{{ @$teacher->fullname_bn ?? @$teacher->fullname }} </p>
                                                <p class="np-card-subtitle">{{@$teacher->designation}}</p>
                                                <p class="np-card-subtitle">ID: {{ @$teacher->pdsid }}</p>
                                                <p class="btn np-btn-form-submit border-0 rounded-1"><i class="fa-solid fa-circle-plus"></i> যুক্ত করুন</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endif
                            @endforeach
                            @foreach(@$banbiesTeachers as $teacher)
                            @if($teacher->emp_uid)
                            <a href="{{ route('teacher.fromBanbies',@$teacher->emp_uid) }}" class="np-route">
                                <div class="card np-card np-profile-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto np-card-image">
                                                <img src="{{ asset('frontend/noipunno/images/avatar/teacher.png') }}" alt="Profile Image" class="rounded-circle" width="50">
                                            </div>
                                            <div class="col np-card-details">
                                                <p class="np-card-title">{{@$teacher->employee_name_bn}} </p>
                                                <p class="np-card-subtitle">{{@$teacher->designation_name}}</p>
                                                <p class="np-card-subtitle">ID: {{@$teacher->emp_uid}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
<style>
  span.error {
    color: red;
  }
</style>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.mutiple-select2').select2();
    });

    const suggestedResultsData = [
        "Suggested Result 1",
        "Suggested Result 2",
        "Suggested Result 3",
        "Suggested Result 4",
        "Suggested Result 5",
    ];

     // for dropdown sorting
     document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('division_id').addEventListener('change', function() {
            var divisionId = this.value;
            var districtOptions = document.querySelectorAll('.district-option');

            // Hide all subject options
            districtOptions.forEach(function(option) {
                option.style.display = 'none';
            });

            // Show subject options that belong to the selected class
            var divisionDistrictOptions = document.querySelectorAll('.district-option.division-' + divisionId);
            divisionDistrictOptions.forEach(function(option) {
                option.style.display = 'block';
            });
        });

        document.getElementById('district_id').addEventListener('change', function() {
            var districtId = this.value;
            var upazilaOptions = document.querySelectorAll('.upazila-option');

            // Hide all subject options
            upazilaOptions.forEach(function(option) {
                option.style.display = 'none';
            });

            // Show subject options that belong to the selected class
            var districtUpazilaOptions = document.querySelectorAll('.upazila-option.district-' + districtId);
            districtUpazilaOptions.forEach(function(option) {
                option.style.display = 'block';
            });
        });

        addPDSTeacherSearchEventListener();
    });

    function updateSuggestedResults(query) {
        const suggestedResults = document.getElementById("suggestedResults");
        suggestedResults.innerHTML = "";

        const filteredResults = suggestedResultsData.filter(result =>
            result.toLowerCase().includes(query.toLowerCase())
        );

        filteredResults.forEach(result => {
            const listItem = document.createElement("a");
            listItem.classList.add("list-group-item");
            listItem.textContent = result;
            listItem.addEventListener("click", function() {
                document.getElementById("searchInput").value = result;
                suggestedResults.innerHTML = "";
            });
            suggestedResults.appendChild(listItem);
        });
    }
    // Event listener for the search input
    // const searchInput = document.getElementById("searchInput");
    // searchInput.addEventListener("input", function() {
    //     const query = this.value.trim();
    //     updateSuggestedResults(query);
    // });

    function fetchDataForPdsidTeacher(pdsid) {
        $.ajax({
        url: '{{ route("teacher.getAllTeachersByPdsID") }}',
        type: 'GET',
        data: {
            id: pdsid,
            '_token': $('input[name="_token"]').val(),
        },
        success: function(data) {
            document.querySelector('.teacher-data-list').style.display='none';
            document.querySelector('.pdsid-teacher-search-result').innerHTML = "";

            for(const teacher of data) {
                let url = `{{ route('teacher.index') }}`;
                url = `${url}/${teacher.pdsid}/emis`;
                const teacherElem = `
                    <a href="${url}" class="np-route">
                                    <div class="card np-card np-profile-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto np-card-image">
                                                    <img src="{{ asset('frontend/noipunno/images/avatar/teacher.png') }}" alt="Profile Image" class="rounded-circle" width="50">
                                                </div>
                                                <div class="col np-card-details">
                                                    <p class="np-card-title">${teacher?.fullname_bn ?? teacher?.fullname} </p>
                                                    <p class="np-card-subtitle">${teacher?.designation}</p>
                                                    <p class="np-card-subtitle">ID: ${teacher?.pdsid}</p>
                                                    <p class="btn np-btn-form-submit border-0 rounded-1"><i class="fa-solid fa-circle-plus"></i> যুক্ত করুন</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                    `;

                document.querySelector('.pdsid-teacher-search-result').insertAdjacentHTML('beforeend',teacherElem);
            }

        }
        }, "json");
    }

    function debounce(cb, interval, immediate) {
        var timeout;

        return function() {
            var context = this, args = arguments;
            var later = function() {
            timeout = null;
            if (!immediate) cb.apply(context, args);
            };

            var callNow = immediate && !timeout;

            clearTimeout(timeout);
            timeout = setTimeout(later, interval);

            if (callNow) cb.apply(context, args);
        };
    };

    function searchKeyPressCallback() {
        const searchInputElem = document.querySelector('#searchInput');
        fetchDataForPdsidTeacher(searchInputElem.value);
    }

    function clearSearchInput() {
        const searchInputElem = document.querySelector('#searchInput');
        searchInputElem.value = "";
        fetchDataForPdsidTeacher("");
    }

    function addPDSTeacherSearchEventListener(){
        const searchInputElem = document.querySelector('#searchInput');
        if(searchInputElem){
            searchInputElem.addEventListener('keydown',debounce(searchKeyPressCallback, 1000));
            document.querySelector('.clear-search').addEventListener('click',clearSearchInput);
        }
    }



</script>
