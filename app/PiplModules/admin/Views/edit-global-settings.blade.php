@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>Update General Configurations</title>
@endsection

@section('content')
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">Update General Configurations</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashbard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/global-settings')}}">Manage General Configurations</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update General Configurations</li>
                </ol>
            </div>
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="update_forms">
                            <form id="updt_global_settings" role="form" action="{{url('/admin/update-global-setting/'.$setting->id)}}" method="post" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="form-group row {{ $errors->has('value') ? ' has-error' : '' }}">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{$setting->name}}</label>
                                    <div class="col-sm-9">
                                        @if(in_array("image",explode("|",$setting->validate)))
                                            <div>
                                                <input name="value" type="file" class="form-control" id="{{$setting->slug}}">
                                            </div>
                                            @if(isset($setting->value) && $setting->value!='')
                                                <img onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png') }}';" src="{{ url('storage/app/public/global-settings/').'/'.$setting->value }}" height="100" width="100">
                                            @endif
                                        @elseif ($setting->id=='4')
                                            <select class='form-control' name='value' id='value'>
                                                <option value='Y-m-d H:m:s'>Y-m-d H:m:s</option>
                                                <option value='Y/m/d H:m:s'>Y-m-d H:m:s</option>
                                                <option value='d-m-Y H:m:s'>d-m-Y H:m:s</option>
                                                <option value='d/m/Y H:m:s'>d/m/Y H:m:s</option>
                                                <option value='m/d/Y H:m:s'>m/d/Y H:m:s</option>
                                                <option value='m-d-Y H:m:s'>m-d-Y H:m:s</option>
                                                <option value='Y-m-d'>Y-m-d</option>
                                                <option value='Y/m/d'>Y/m/d</option>
                                                <option value='d-m-Y'>d-m-Y</option>
                                                <option value='d/m/Y'>d/m/Y</option>
                                                <option value='m/d/Y'>m/d/Y</option>
                                                <option value='m-d-Y'>m-d-Y</option>
                                            </select>
                                        @elseif ($setting->id=='16' || $setting->id=='29')
                                            <textarea name="value"  class="form-control" id="{{$setting->slug}}">{{old('value',$setting->value)}}</textarea>
                                        @else
                                            <input name="value" type="text" class="form-control" id="{{$setting->slug}}" value="{{old('value',$setting->value)}}">
                                        @endif
                                        @if ($errors->has('value'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit" class="btn btn-theme">Update</button>
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