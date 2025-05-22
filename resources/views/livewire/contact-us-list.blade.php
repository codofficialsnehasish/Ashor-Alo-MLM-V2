<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Contact Us</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Contact Us</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="flex justify-between items-center mb-6">
                            <div class="w-1/3">
                                <input 
                                    type="text" 
                                    wire:model.live="search" 
                                    placeholder="Search messages..." 
                                    class="form-control"
                                >
                            </div>
                       </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email/Phone</th>
                                                <th>Message</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($contacts as $contact)
                                                <tr>
                                                    <td>{{ $contact->name }}</td>
                                                    <td>{{ $contact->email_or_phone }}</td>
                                                    <td class="text-wrap">
                                                        {{ $contact->message }}
                                                    </td>
                                                    <td>{{ $contact->created_at->format('M d, Y h:i A') }}</td>
                                                    <td>
                                                        <button 
                                                            wire:click="delete({{ $contact->id }})" 
                                                            class="btn btn-danger btn-sm"
                                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                        >
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No contact messages found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            {{ $contacts->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>