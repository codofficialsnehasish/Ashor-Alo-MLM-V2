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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body mb-n3">
                                <a class="btn btn-outline-primary btn-sm px-4 mt-0 mb-3"  href="{{ route('createUser')}}" wire:navigate>
                                    Add New <i class="ti-plus"></i> 
                                </a>
                                
                                
                                <div class="table-responsive">

                                    <table class="table mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Reg Date</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>Status</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                        
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ format_datetime($user->created_at) }}</td>
                                                    <td> 
                                                        @if ($user->hasMedia('user'))
                                                        <img src="{{ $user->getFirstMediaUrl('user') }}" alt="" 
                                                            style="width: 40px; height: 40px; object-fit: cover;" 
                                                            class="rounded-circle me-2"> 
                                                        @endif
                                                        {{ $user->name }} 
                                                    </td>
                                                    <td>
                                                        @if (!empty($user->getRoleNames()))
                                                            @foreach ($user->getRoleNames() as $role)
                                                            <span class="badge badge-primary">{{ $role }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->decoded_password }}</td>
                                                    <td>
                                                        <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
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
 