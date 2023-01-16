@php
    $breadcrumbs = [
                        ['url' => '', 'name' => trans('Permissions::permissions.permissions')]
    ];
    $dbTable = '';
    if($items->count()){
        $dbTable = $items[0]['table'];
    }
@endphp
@extends('admin.master')
@section('title')
    {{ trans('Permissions::permissions.permissions') }}
@endsection
@section('content')
    <div class="right-auth-landing">
        <div class="all-heads">
            <h3>Permissions  </h3>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                <li class="active">
                    Permissions
                </li>
            </ol>
            {{--<h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>--}}
        </div>
        <div class="table-responsive essay-table">
            {{--<a class="btn btn-default" href="{{ route('admin.permissions.create') }}">Create New Permission</a>--}}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th style="width: 70px;">#</th>
                    <th style="width: 400px;">Name</th>
                    <th style="width: 300px;">Slug</th>
                    <th style="width: 500px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($items))
                    @foreach($items as $k => $item)
                        <tr>
                            <th>{{ $item->id }}</th>
                            <td>{{ $item->trans->name }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>--</td>
                            {{--<td>Globle Setting, All Sub Admin, Create Sub Admin, All Role, CMS Pages, Essay listing, Essay Assignment, Essay Feedback <b>(All)</b></td>--}}
                        </tr>
                    @endforeach
                @endif
                {{--<tr>
                    <th>2</th>
                    <td>Super Admin</td>
                    <td>Globle Setting, All Sub Admin, Create Sub Admin, Essay Assignment, Essay Feedback</td>
                </tr>--}}
                {{--<tr>
                    <th>3</th>
                    <td>Sub Admin</td>
                    <td>Globle Setting, All Sub Admin, Create Sub Admin, All Role, CMS Pages, Essay Feedback</td>
                </tr>
                <tr>
                    <th>4</th>
                    <td>Supervisor</td>
                    <td>Globle Setting, All Sub Admin, Create Sub Admin, All Role, CMS Pages</td>
                </tr>
                <tr>
                    <th>5</th>
                    <td>Manager</td>
                    <td> All Role, CMS Pages, Essay listing, Essay Assignment, Essay Feedback</td>
                </tr>
                <tr>
                    <th>6</th>
                    <td>Essay Management</td>
                    <td>Globle Setting, All Sub Admin, Essay listing, Essay Assignment, Essay Feedback</td>
                </tr>--}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer')

@endsection