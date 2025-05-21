<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Order</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Orders & Products</a></li>
                                <li class="active">Orders</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <!-- Filters -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <input type="text" wire:model.live="search" class="form-control" placeholder="Search orders...">
                                </div>
                                <div class="col-md-2">
                                    <select wire:model.live="statusFilter" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="paid">Paid</option>
                                        <option value="pending">Pending</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" wire:model.live="dateFilter" class="form-control">
                                </div>
                                <div class="col-md-3 text-right">
                                    <button wire:click="resetFilters" class="btn btn-outline-secondary">
                                        Reset Filters
                                    </button>
                                </div>

                                <div class="col-md-2 text-right">
                                    <a href="{{ route('orders.add') }}" class="btn btn-primary">
                                        <i class="ti-plus"></i> Create Order
                                    </a>
                                </div>
                            </div>

                            <!-- Orders Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                                                Date
                                            </th>
                                            <th wire:click="sortBy('order_number')" style="cursor: pointer;">
                                                Order ID #
                                            </th>
                                            <th>Customer</th>
                                            <th>Customer ID</th>
                                            <th>Category</th>
                                            <th wire:click="sortBy('price_total')" style="cursor: pointer;">
                                                Amount
                                            </th>
                                            <th>Payment Method</th>
                                            <th wire:click="sortBy('payment_status')" style="cursor: pointer;">
                                                Payment Status
                                            </th>
                                            <th>Order Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $order)
                                        <tr>
                                            <td>{{ format_datetime($order->created_at) }}</td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->user->getMemberNumberAttribute() }}</td>
                                            <td>{{ $order->category->name }}</td>
                                            <td>{{ number_format($order->price_total, 2) }}</td>
                                            <td>{{ $order->payment_method }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($order->payment_status === 'Paid') badge-success
                                                    @elseif($order->payment_status === 'Awaiting Payment') badge-warning
                                                    @elseif($order->payment_status === 'Under Checking') badge-danger
                                                    @endif">
                                                    {{ $order->payment_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($order->order_status === 'Order Placed') badge-info
                                                    @elseif($order->order_status === 'Order Procesing') badge-warning
                                                    @elseif($order->order_status === 'Order Shipped') badge-danger
                                                    @elseif($order->order_status === 'Order Completed') badge-success
                                                    @endif">
                                                    {{ $order->order_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.print', $order->id) }}" 
                                                class="btn btn-sm btn-primary" title="View">
                                                    <i class="ti-eye"></i>
                                                </a>
                                                <a wire:click="delete({{ $order->id }})" 
                                                class="btn btn-sm btn-danger" title="Delete" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                                                    <i class="ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No orders found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="row">
                                <div class="col-md-6">
                                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} 
                                    of {{ $orders->total() }} entries
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right">
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-danger {
        background-color: #dc3545;
        color: white;
    }
    .table th {
        white-space: nowrap;
    }
</style>
@endpush