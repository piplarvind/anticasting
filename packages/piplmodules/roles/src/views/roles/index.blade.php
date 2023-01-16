@php
    $breadcrumbs = [
                        ['url' => '', 'name' => trans('Roles::roles.roles')]
    ];
    $dbTable = '';
    if($items->count()){
        $dbTable = $items[0]['table'];
    }
@endphp
@extends('admin.master')
@section('title')
    {{ trans('Roles::roles.roles') }}
@endsection
@section('content')
    <div class="right-auth-landing">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
        <div class="all-heads">
            <h3>Roles  </h3>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                <li class="active">
                    Roles
                </li>
            </ol>
            {{--<h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>--}}
        </div>
        <div class="table-responsive essay-table">
            <a class="btn btn-success pull-right" style="margin-bottom: 5px;" href="{{ route('admin.roles.create') }}">Create New Role</a>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th style="width: 70px;">#</th>
                    <th style="width: 200px;">Name</th>
                    <th style="width: 500px;">Display Pages</th>
                    <th style="width: 500px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($items))
                    @foreach($items as $k => $item)
                        <tr>
                            <th>{{ $item->id }}</th>
                            <td>{{ $item->trans->name }}</td>
                            <td>
                                @if(isset($item->hasPermission))
                                    @foreach($item->hasPermission as $k => $pItem)
                                        @if(isset($pItem->getPermission->trans))
                                            {{ $pItem->getPermission->trans->name }},
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <span class="act-link">
                                    <a href="{{ route('admin.roles.edit', $item->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i> {{ trans('Core::operations.edit') }}</a>
                                </span>
                                {{--<span class="act-link">
                                    <a href="{{ route('admin.essay-topics.delete', $item->id) }}" onclick="return confirm('Do you really want to delete this record?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" ><i class="fa fa-trash"></i> {{ trans('Core::operations.delete') }}</a>
                                </span>--}}
                            </td>
                            {{--<td>Globle Setting, All Sub Admin, Create Sub Admin, All Role, CMS Pages, Essay listing, Essay Assignment, Essay Feedback <b>(All)</b></td>--}}
                        </tr>
                    @endforeach
                @endif
                {{--<tr>
                    <th>2</th>
                    <td>Super Admin</td>
                    <td>Globle Setting, All Sub Admin, Create Sub Admin, Essay Assignment, Essay Feedback</td>
                </tr>--}}
                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>
@endsection
@section('footer')

@endsection