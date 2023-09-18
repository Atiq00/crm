@extends('admin.layouts.app', [ 'current_page' => 'lead_users' ])

@section('content')

<style> 
</style>

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          {{-- <a href="{{ route('createclient_user') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="plus" stroke-width="3" width="12"></i> {{ __('labels.new_user') }}</a> --}}
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => "Lead Position Users"])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center"> 
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">SR #</th>
                                    <th scope="col">HRMSID</th>
                                    <th scope="col">{{ __('labels.name') }}</th> 
                                    <th scope="col">{{ __('labels.email') }}</th>    
                                    <th scope="col">{{ __('labels.role') }}</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Projects</th>
                                    <th scope="col">{{ __('labels.created_at') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($users as $user)   
                                @if($user->roles->first())                                    
                                    <tr>                                        
                                        <td>
                                            <a href="#">
                                                @php
                                                    if(!isset($counter))
                                                    {
                                                        $counter = 1;
                                                    }
                                                   echo $counter++;
                                                @endphp 
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}">{{$user->HRMSID}}</a>
                                        </td>
                                        <td class="table-user">
                                            <img alt="Image placeholder" src="{{ asset('uploads/user/'.$user->image) }}" class="avatar avatar-sm rounded-circle profile-user-image">
                                            <b class="pl-3">{{ $user->name }}</b>
                                        </td> 
                                        <td>
                                            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                                        </td>  
                                        <td>
                                            <span class="badge badge-secondary">{{ @$user->roles->first()->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ @$user->designation}}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">
                                                @php
                                                    if($user->projects){
                                                        $name='';
                                                        foreach ($user->projects as $key => $value) {
                                                            $name .="[".$value->name."]-";
                                                        }
                                                        echo substr($name,0,-1);
                                                    }   
                                                @endphp
                                            </span>
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('users.edit')
                                                        <a class="dropdown-item" href="{{ route('edit_lead_user', $user->id) }}">{{ __('labels.edit') }}</a>
                                                    @endcan
                                                    @can('users.delete')
                                                        <a class="dropdown-item delete-btn" href="#" onclick="if(confirm('{{ __('labels.confirm_delete') }}')){  $('#FORM_DELETE').attr('action', '{{ route('users.destroy', $user->id) }}').submit(); }" >{{ __('labels.delete') }}</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="6">
                                        {{ __('labels.no_data_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        @include('admin.layouts.footers.auth')



    </div>
@endsection


@push('js')

<script>
    $(document).ready(() => {

        $('#basic-datatable').DataTable({
            "pageLength": 50
        });
    });
</script>

<form action="#" method="post" id="FORM_DELETE">
    @csrf
    @method('DELETE')
</form>
@endpush
