<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>System Users</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">System Users</li>
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
                                        <button wire:click="exportPDF" class="btn btn-danger me-2">
                                            <i class="fas fa-file-pdf me-1"></i> PDF Export
                                        </button>
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
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ format_datetime($user->created_at) }}</td>
                                                <td>{{ format_datetime($user->created_at) }}</td>
                                                <td>{{ $user->name }} </td>
                                                <td>{{ ucFirst($user->binaryNode->position) }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->decoded_password }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->binaryNode->status }}</td>
                                                <td>{{ $user->binaryNode->sponsor_id }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('user.edit', ['id' => Crypt::encryptString($user->id)]) }}" wire:navigate><i class="ti-pencil-alt text-secondary font-16 text-info"></i></a>
                                                    <a href="javascript:;" onclick="confirmDeletion({{ $user->id }})"><i class="ti-trash text-secondary font-16 text-danger"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>           
                                    {{ $users->links(data: ['scrollTo' => false]) }}         
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
 