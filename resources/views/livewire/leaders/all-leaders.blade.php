<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Leader</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a wire:navigate href="{{ route('leaders.all') }}">Leaders</a></li>
                                <li class="active">All Leaders</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body mb-n3">
                                <a class="btn btn-outline-primary btn-sm px-4 mt-0 mb-3" wire:navigate href="{{ route('leaders.create')}}" >
                                    Add New <i class="ti-plus"></i> 
                                </a>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 d-flex align-items-end">
                                        {{-- <button wire:click="exportPDF" class="btn btn-danger me-2">
                                            <i class="fas fa-file-pdf me-1"></i> PDF Export
                                        </button> --}}
                                        <button wire:click="exportExcel" class="btn btn-success">
                                            <i class="fas fa-file-excel me-1"></i> Excel Export
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Search</label>
                                        {{-- <select wire:model.live="user_id" class="form-control">
                                            <option value="">All Users</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }} @if($user->roles->count()) ({{ $user->roles->pluck('name')->join(', ') }}) @endif
                                                </option>
                                            @endforeach
                                        </select> --}}
                                        <input type="search" wire:model.live="query" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="table-responsive">

                                    <table class="table mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Reg Date</th>
                                                <th>Active Date</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Mobile</th>
                                                <th>Password</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Sponsor Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            <tr>
                                                <td style="text-align: center; font-weight: 500; vertical-align: middle; padding: 8px;">{{ $loop->iteration }}</td>
                                                <td style="vertical-align: middle;">{{ format_datetime($user->created_at) }}</td>
                                                <td style="vertical-align: middle;">{{ !empty($user->binaryNode->activated_at) ? format_datetime($user->binaryNode->activated_at) : '' }}</td>
                                                
                                                
                                                <td style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                                @if ($user->hasMedia('profile-image'))
                                                    <img src="{{ $user->getFirstMediaUrl('profile-image') }}" 
                                                         alt="{{ $user->name }}" 
                                                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets/images/treeUser/user.png') }}" 
                                                         alt="{{ $user->name }}" 
                                                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                @endif
                                                <div style="text-align: center;">
                                                    {{ $user->name }} ({{ $user->binaryNode->member_number }})
                                                </div>
                                            </td>
                                                <td style="vertical-align: middle;">{{ ucFirst($user->binaryNode->position) }}</td>
                                                <td style="vertical-align: middle;">{{ $user->phone }}</td>
                                                <td style="vertical-align: middle;">{{ $user->decoded_password }}</td>
                                                <td style="vertical-align: middle;">{{ $user->email }}</td>
                                                <td style="vertical-align: middle;">{!! check_status($user->binaryNode->status) !!}</td>
                                                <td style="vertical-align: middle;">{{ $user->binaryNode?->sponsor?->user?->name ?? '' }} @if($user->binaryNode?->sponsor)({{$user->binaryNode?->sponsor?->member_number}})@endif</td>
                                                <td class="text-end d-flex" style="vertical-align: middle; padding-bottom: 20px; gap:4px;">
                                                    <a href="{{ route('leaders.edit', ['id' => Crypt::encryptString($user->id)]) }}" wire:navigate class="bg-info p-2 rounded me-1"><i class="ti-pencil-alt text-secondary font-16 text-white"></i></a>
                                                    <a href="javascript:;" wire:click="confirmDeletion({{ $user->id }})" class="bg-danger p-2 rounded"><i class="ti-trash text-secondary font-16 text-white"></i></a>
                                                    @if($user->is_block == 0)
                                                    <div style="margin:auto 0">
                                                    <a wire:click="make_block({{ $user->id }})"><img src="{{ asset('assets/images/block.png') }}" height="30px" alt="" style="margin-left:1px"></a>
                                                    </div>
                                                    @else
                                                    <div style="margin:auto 0">
                                                    <a wire:click="make_block({{ $user->id }})"><img src="{{ asset('assets/images/unblock.png') }}" height="30px" style="margin-left:1px" alt=""></a>
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                    {{ $users->links(data: ['scrollTo' => false]) }}         
                                    </div>
                                </div>                                         
                            </div><!--end card-body--> 
                        </div><!--end card--> 
                    </div> <!--end col-->                               
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDeletion(itemId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteItem', { id: itemId}); // Dispatch Livewire event
            }
        });
    }
</script>
 