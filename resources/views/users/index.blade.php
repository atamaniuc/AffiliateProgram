@extends('layouts.master')

@section('content')

    <h1>Users <a href="{{ url('admin/users/create') }}" class="btn btn-primary pull-right btn-sm">Add New User</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th>Name</th><th>Email</th><th>Amount</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($users as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{ url('admin/users', $item->id) }}">{{ $item->name }}</a></td><td>{{ $item->email }}</td><td>{{ $item->total_amount }}</td>
                    <td>
                        <a href="{{ url('admin/users/' . $item->id . '/edit') }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a>

                        <!-- Don't render DELETE for current user -->
                        @if ($item->id !== Auth::user()->id)
                            /{!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['admin/users', $item->id],
                                'style' => 'display:inline'
                            ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        @endif
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{--TODO: make pagination on Users Collection--}}
        {{--<div class="pagination"> {!! $users->render() !!} </div>--}}
    </div>

@endsection
