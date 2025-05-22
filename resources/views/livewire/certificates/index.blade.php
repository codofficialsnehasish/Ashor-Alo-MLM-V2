<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Certificates</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Certificates</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="flex justify-between items-center mb-4">
                                <input type="text" wire:model.live="search" placeholder="Search..." class="input input-bordered">
                                <a href="{{ route('certificates.create') }}" class="btn btn-primary">
                                    Create Certificate
                                </a>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="table w-full">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th wire:click="sortBy('title')" class="cursor-pointer">
                                                Title
                                                @if($sortField === 'title')
                                                    @if($sortDirection === 'asc')
                                                        ↑
                                                    @else
                                                        ↓
                                                    @endif
                                                @endif
                                            </th>
                                            <th>Image</th>
                                            <th wire:click="sortBy('is_active')" class="cursor-pointer">
                                                Status
                                                @if($sortField === 'is_active')
                                                    @if($sortDirection === 'asc')
                                                        ↑
                                                    @else
                                                        ↓
                                                    @endif
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('created_at')" class="cursor-pointer">
                                                Created
                                                @if($sortField === 'created_at')
                                                    @if($sortDirection === 'asc')
                                                        ↑
                                                    @else
                                                        ↓
                                                    @endif
                                                @endif
                                            </th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($certificates as $certificate)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $certificate->title }}</td>
                                                <td>
                                                    @if($certificate->hasMedia('certificate_images'))
                                                        <img src="{{ $certificate->getFirstMediaUrl('certificate_images', 'thumb') }}" 
                                                            alt="{{ $certificate->title }}" 
                                                            class="w-16 h-16 object-cover" width="60px">
                                                    @else
                                                        No image
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge {{ $certificate->is_active ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $certificate->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>{{ $certificate->created_at->format('Y-m-d') }}</td>
                                                <td class="flex space-x-2">
                                                    <a href="{{ route('certificates.edit', $certificate) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <button wire:click="delete({{ $certificate->id }})" class="btn btn-sm btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No certificate found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $certificates->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>