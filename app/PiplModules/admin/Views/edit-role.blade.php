@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>Update Role</title>
@endsection

@section('content')
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">Update Role</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/manage-roles')}}">Manage Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Role</li>
                </ol>
            </div>
            @if (session('create-role-status'))
                <div class="alert alert-success">
                    {{ session('create-role-status') }}
                </div>
            @endif
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="update_forms update_user modified_updateform">
                            <form id="frm_update_role" name="frm_update_role" role="form" action="{{url('/admin/update-role/'.$role->id)}}" method="post" >
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label text-right">Name:<sup style="color: red">*</sup></label>
                                            <div class="col-sm-7">
                                                <input name="name" type="text" class="form-control-plaintext custom_input" id="name" value="{{old('name',$role->name)}}">
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label text-right">Slug:<sup style="color: red">*</sup></label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control-plaintext custom_input" id="slug" name="slug" value="{{old('slug',$role->slug)}}">
                                                @if ($errors->has('slug'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('slug') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label text-right">Description:</label>
                                            <div class="col-md-7">
                                                <textarea class="form-control-plaintext custom_input" id="description" name="description">{{old('description',$role->description)}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit" id="btnSubmit" class="btn btn-theme">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection