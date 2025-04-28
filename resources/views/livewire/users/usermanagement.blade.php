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
                                                <th>Sl No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                        
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td> <img src="{{ $user->getFirstMediaUrl('user') }}" alt="" class="thumb-sm rounded-circle me-2"> {{ $user->name }} 
                                                    
                                                    
                                                    </td>
                                                    <td> {{ $user->email }}</td>
                                                    <td>
                                                        @if (!empty($user->getRoleNames()))
                                                            @foreach ($user->getRoleNames() as $role)
                                                            <span class="badge badge-primary">{{ $role }}</span>
                                                            @endforeach
                                                        @endif
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
 