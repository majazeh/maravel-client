@extends($layouts->dashboard)
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Users') }} <sup>({{$users->total()}})</sup>
            @filterBadge($users)
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>@sortView($users,'id', '#')</th>
                            <th>@sortView($users,'name', __('Display name'))</th>
                            <th>@sortView($users,'email', __('Email'), '<i class="far fa-envelope"></i>')</th>
                            <th>@sortView($users,'mobile', __('Mobile'), '<i class="fas fa-mobile-alt"></i>')</th>
                            <th class="d-none d-sm-table-cell">
                                @sortView($users,'gender', __('Gender'), '<i class="fas fa-venus-mars"></i>')
                                @filterView($users, 'gender')
                            </th>
                            <th>
                                @sortView($users,'status', __('Status'), '<i class="fas fa-user-shield"></i>')
                                @filterView($users, 'status')
                            </th>
                            <th>
                                @sortView($users,'type', __('Type'), '<i class="fas fa-award"></i>')
                                @filterView($users, 'type')
                            </th>
                            <th>@sortView($users,'username', __('Username'), '<i class="fas fa-at"></i>')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>@id($user)</td>
                                <td>{{ $user->name }}</td>
                                <td>@email($user->email)</td>
                                <td>@mobile($user->mobile)</td>
                                <td class="d-none d-sm-table-cell">{{ $user->gender ? __(ucfirst($user->gender)) : '' }}</td>
                                <td>
                                    <span class="d-none d-sm-inline">
                                        {{ __(ucfirst($user->status)) }}
                                    </span>
                                    <span class="d-sm-none">
                                        {{ mb_substr(__(ucfirst($user->status)), 0, 2) }}
                                    </span>

                                </td>
                                <td>
                                    <span class="d-none d-sm-inline">
                                        {{ __(ucfirst($user->type)) }}
                                    </span>
                                    <span class="d-sm-none">
                                        {{ mb_substr(__(ucfirst($user->type)), 0, 2) }}
                                    </span>
                                </td>
                                <td>@username($user->username)</td>
                                <td>
                                    @includeFirst(['dashboard.users._cogs', 'dashboard.users.cogs'])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{$users->render()}}
            </div>
        </div>
    </div>
@endsection
