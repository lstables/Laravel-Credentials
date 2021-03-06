@extends(Config::get('views.default', 'layouts.default'))

@section('title')
{{{ $user->getName() }}}
@stop

@section('top')
<div class="page-header">
<h1>{{{ $user->getName() }}}</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-6">
        <p class="lead">
            @if($user->id == Credentials::getUser()->id)
                Currently showing your profile:
            @else
                Currently showing {{ $user->getName() }}'s profile:
            @endif
        </p>
    </div>
    <div class="col-xs-6">
        <div class="pull-right">
            @if (Credentials::check() && Credentials::hasAccess('admin'))
                &nbsp;<a class="btn btn-info" href="{{ URL::route('users.edit', array('users' => $user->id)) }}"><i class="fa fa-pencil-square-o"></i> Edit User</a>
            @endif
            &nbsp;<a class="btn btn-warning" href="#suspend_user" data-toggle="modal" data-target="#suspend_user"><i class="fa fa-ban"></i> Suspend User</a>
            @if (Credentials::check() && Credentials::hasAccess('admin'))
                &nbsp;<a class="btn btn-inverse" href="#reset_user" data-toggle="modal" data-target="#reset_user"><i class="fa fa-lock"></i> Reset Password</a>
                &nbsp;<a class="btn btn-danger" href="#delete_user" data-toggle="modal" data-target="#delete_user"><i class="fa fa-times"></i> Delete</a>
            @endif
        </div>
    </div>
</div>
<hr>
<h3>User Profile</h3>
<div class="well clearfix">
    <div class="hidden-xs">
        <div class="col-xs-6">
            @if ($user->first_name)
                <p><strong>First Name:</strong> {{ $user->first_name }} </p>
            @endif
            @if ($user->last_name)
                <p><strong>Last Name:</strong> {{ $user->last_name }} </p>
            @endif
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
        <div class="col-xs-6">
            <div class="pull-right">
                <p><em>Account Created: {{ $user->created_at->diffForHumans() }}</em></p>
                <p><em>Account Updated: {{ $user->updated_at->diffForHumans() }}</em></p>
                @if ($user->activated_at)
                    <p><em>Account Activated: {{ $user->activated_at->diffForHumans() }}</em></p>
                @else
                    <p><em>Account Activated: Not Activated</em></p>
                @endif
            </div>
        </div>
    </div>
    <div class="visible-xs">
        <div class="col-xs-12">
            @if ($user->first_name)
                <p><strong>First Name:</strong> {{ $user->first_name }} </p>
            @endif
            @if ($user->last_name)
                <p><strong>Last Name:</strong> {{ $user->last_name }} </p>
            @endif
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Account Created:</strong> {{ $user->created_at->diffForHumans() }}</p>
            <p><strong>Account Updated:</strong> {{ $user->updated_at->diffForHumans() }}</p>
            @if ($user->activated_at)
                <p><strong>Account Activated:</strong> {{ $user->activated_at->diffForHumans() }}</p>
            @else
                <p><strong>Account Activated:</strong> Not Activated</p>
            @endif
        </div>
    </div>
</div>
<hr>
<h3>User Group Memberships</h3>
<div class="well">
    <ul>
    @if (count($user->getGroups()) >= 1)
        @foreach ($user->getGroups() as $group)
            <li>{{ $group['name'] }}</li>
        @endforeach
    @else
        <li>No Group Memberships.</li>
    @endif
    </ul>
</div>
<hr>
<h3>User Object</h3>
<div>
    <pre>{{ var_dump($user) }}</pre>
</div>
@stop

@section('bottom')
@include('graham-campbell/credentials::users.suspend')
@if (Credentials::check() && Credentials::hasAccess('admin'))
    @include('graham-campbell/credentials::users.reset')
    @include('graham-campbell/credentials::users.delete')
@endif
@stop
