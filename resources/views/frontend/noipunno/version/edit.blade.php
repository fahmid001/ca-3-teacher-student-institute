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
                                    <h2 class="title">ভার্সন ব্যবস্থাপনা</h2>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb np-breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{route('home')}}">
                                                    <img src="{{ asset('frontend/noipunno/images/icons/home.svg') }}" alt="">
                                                    ড্যাশবোর্ড
                                                </a></li>
                                            <li class="breadcrumb-item active" aria-current="page">ভার্সন ব্যবস্থাপনা</li>
                                        </ol>
                                    </nav>

                                </div>
                            </div>
                            <div class="option-section d-none">
                                <div class="fav-icon">
                                    <img src="{{ asset('frontend/noipunno/images/icons/fav-start-icon.svg') }}" alt="">
                                </div>
                                <div class="dots-icon">
                                    <img src="{{ asset('frontend/noipunno/images/icons/3-dot-vertical.svg') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <section class="np-teacher-list mt-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="title mb-3">ভার্সন লিস্ট</h2>
                            </div>

                            <div class="col-md-12">
                                <div class="card np-card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table np-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ভার্সনের নাম
                                                            {{-- <span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}" alt=""></span> --}}
                                                        </th>
                                                        {{-- <th scope="col">ভার্সন আইডি<span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}" alt=""></span></th> --}}
                                                        <th scope="col">ব্রাঞ্চের নাম
                                                            {{-- <span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/filter.svg') }}" alt=""></span> --}}
                                                        </th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($versionList as $version)
                                                    <tr>
                                                        <td scope="row"><span class="icon"><img src="{{ asset('frontend/noipunno/images/icons/user.svg') }}" alt=""></span>{{ @$version->version_name }}</th>
                                                            {{-- <td scope="row">{{ @$version->version_id }}</th> --}}
                                                        <td scope="row">{{ @$version->branch->branch_name }}</th>
                                                        <td scope="row">
                                                            <div class="action-content">
                                                                <!-- <h2 class="created-date">{{ date('j F Y', strtotime(@$version->created_at)) }}</h2> -->
                                                                <a href="{{ route('noipunno.dashboard.version.edit',['id'=> @$version->uid]) }}" class="np-route">
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

                            <!-- <div class="col-md-12">
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
                            </div> -->
                        </div>
                    </div>
                </section>

                <div>
                    <div class="np-pagination-section d-flex justify-content-end align-items-center">
                        <div class="np-select-page-number d-flex align-items-center">
                            {{ $versionList->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>

                <h2 class="np-form-title mt-5">ভার্সন তথ্য পরিবর্তন করুন</h2>

                <section class="section-teacher-add-form mt-3 np-input-form-bg mb-5" id="edit-form">
                    <div class="container">
                        <form action="{{ route('noipunno.dashboard.version.update', ['id'=>@$versionData->uid]) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="row">
                                <!-- <div class="col-md-4 col-sm-12">
                                    <div>
                                        <label for="beiin-psid" class="form-label">ভার্সন আইডি </label>
                                        <input type="number" class="form-control np-teacher-input" id="loginId" placeholder="123" name="version_id" value="{{ @$version->version_id }}" readonly>
                                    </div>
                                </div> -->

                                <div class="col-md-4 col-sm-12">
                                    <div>
                                        <label for="beiin-psid" class="form-label">ভার্সনের নাম <span class="text-danger">*</span></label>
                                        <select class="form-select np-teacher-input" aria-label="Default select example" name="version_name">
                                            <option value="বাংলা" {{ old('version_name', @$versionData->version_name) == 'বাংলা' ? 'selected' : '' }}>বাংলা ভার্সন </option>
                                            <option value="ইংলিশ"  {{ old('version_name', @$versionData->version_name) == 'ইংলিশ' ? 'selected' : '' }}>ইংলিশ ভার্সন </option>
                                            </select>
                                            @if ($errors->has('version_name'))
                                        <small class="help-block form-text text-danger">{{ $errors->first('version_name') }}</small>
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="col-md-4 col-sm-12">
                                    <div>
                                        <label for="beiin-psid" class="form-label">EIIN নম্বর</label>
                                        <input type="text" class="form-control np-teacher-input" id="loginId" placeholder="EIIN নম্বর" name="eiin" value="{{ @$versionData->eiin }}" readonly>
                            </div>
                    </div> --}}

                    <div class="col-md-4 col-sm-12">
                        <div>
                            <label for="beiin-psid" class="form-label">ব্রাঞ্চ</label>
                            <div class="input-group">
                                <select class="form-select np-teacher-input" aria-label="Default select example" name="branch_id">
                                    <option value="">ব্রাঞ্চ নির্বাচন করুন</option>
                                    @foreach($myBranches as $branch)
                                    <option value="{{$branch->uid}}" @if(old('branch_id', @$versionData->branch_id) == $branch->uid) selected @endif>{{$branch->branch_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('branch_id'))
                            <small class="help-block form-text text-danger">{{ $errors->first('branch_id') }}</small>
                            @endif
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary np-btn-form-submit mt-3 d-flex align-items-center" style="width: fit-content;border: unset;column-gap: 10px;"> <a class="np-btn-cancel" href="{{ route('noipunno.dashboard.version.add') }}">বাতিল করুন</a>
                        <img src="{{ asset('frontend/noipunno/images/icons/arrow-right.svg') }}" alt=""></button>
                    <button type="submit" class="btn btn-primary np-btn-form-submit mt-3 mx-5 d-flex align-items-center" style="width: fit-content;border: unset;column-gap: 10px;">তথ্য হালনাগদ করুন
                        <img src="{{ asset('frontend/noipunno/images/icons/arrow-right.svg') }}" alt=""></button>
                </div>
            </div>
            </form>
        </div>
        </section>
    </div>
</div>
</div>



</div>

<script>
    $(document).ready(function() {
        document.getElementById("edit-form").scrollIntoView({
            "behavior": "smooth"
        });
    });
</script>

@endsection
