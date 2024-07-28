@extends('admin.layouts.master')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Premiums</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Device Name</th>
                        <th>Device UUID</th>
                        <th>Product ID</th>
                        <th>Remaining Chat Credit</th>
                        <th>Is Premium</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userPremiums as $userPremium)
                    <tr>
                        <td>{{ $userPremium->device->name }}</td>
                        <td>{{ $userPremium->device_uuid }}</td>
                        <td>{{ $userPremium->product_id }}</td>
                        <td>{{ $userPremium->remaining_chat_credit }}</td>
                        <td>
                            @switch($userPremium->is_active)
                                @case(0)
                                <span class="badge badge-danger">No</span>
                                @break
                                @case(1)
                                <span class="badge badge-success">Yes</span>
                                @break
                            @endswitch
                        </td>
                        <td>{{ $userPremium->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
