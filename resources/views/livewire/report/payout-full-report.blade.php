<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>{{ $title }}</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Reports</a></li>
                                <li class="active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-item-center">
                                    <div class="col-md-3">
                                        <label for="searchs">Search User</label>
                                        <input type="text" class="form-control" id="searchs" placeholder="Search" wire:model.live="search">
                                    </div>
                                    <div class="col-md-6">
                                        <button wire:click="backToSummary" class="btn btn-secondary me-2">
                                            Back to Summary
                                        </button>
                                        <button wire:click="exportFullExcel" class="btn btn-success me-2">
                                            Export Excel
                                        </button>
                                        <button wire:click="exportFullPDF" class="btn btn-danger">
                                            Export PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-wrap">Paid / Unpaid</th>
                                                <th class="text-wrap">Name</th>
                                                <th class="text-wrap">ID</th>
                                                <th class="text-wrap">Total Payout Amount</th>
                                                <th class="text-wrap">Account Name (As Per Bank)</th>
                                                <th class="text-wrap">Bank Name</th>
                                                <th class="text-wrap">Account Number</th>
                                                <th class="text-wrap">IFSC</th>
                                                <th class="text-wrap">Account Type</th>
                                                <th class="text-wrap">UPI Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total_payout_amount = 0; @endphp
                                            @forelse($items as $item)
                                                @php $total_payout_amount += $item->total_payout; @endphp
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" 
                                                            wire:click="handleCheckboxClick({{ $item->id }}, {{ $item->paid_unpaid ? 'true' : 'false' }})"
                                                            {{ $item->paid_unpaid ? 'checked' : '' }} wire:loading.attr="disabled">
                                                    </td>
                                                    <td class="text-wrap"><a href="javascript:void(0);" wire:click="payout_statement({{ $item->id}})">{{ $item->user->name ?? '' }}</a></td>
                                                    <td class="text-wrap">{{ $item->user->member_number ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->total_payout ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->account_name ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->bank_name ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->account_number ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->ifsc_code ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->account_type ?? '' }}</td>
                                                    <td>
                                                        <Strong>UPI Type : </Strong> {{ $item->user?->bankDetails?->upi_type ?? '' }}<br>
                                                        <Strong>UPI Number : </Strong> {{ $item->user?->bankDetails?->upi_number ?? '' }}<br>
                                                        <Strong>UPI Name : </Strong> {{ $item->user?->bankDetails?->upi_name ?? '' }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">No transactions found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Total</td>
                                                <td>{{ $total_payout_amount }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    {{ $items->links() }}
                                </div>
     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Status Modal -->
    @if($showStatusModal)
    {{-- <div class="modal fade d-block" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true"> --}}
    <div class="modal show d-block" id="statusModal" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background: rgba(0, 0, 0, .6);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="statusModalForm" wire:submit.prevent="updatePaymentStatus">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Update Payment Status {{ $selectedItemId }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeStatusModal()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="modalItemId" name="item_id" wire:model="selectedItemId">
                        <div class="form-group mb-3">
                            <label for="paymentDate" class="form-label">Payment Date</label>
                            <input type="date" class="form-control" id="paymentDate" name="payment_date" wire:model="paymentDate" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="paymentMode" class="form-label">Payment Mode</label>
                            <select class="form-control" id="paymentMode" name="payment_mode" wire:model="paymentMode" required>
                                <option value="Cash" selected>Cash</option>
                                <option value="NEFT">NEFT</option>
                                <option value="UPI">UPI</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeStatusModal()" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    // document.addEventListener('livewire:init', () => {
    //     Livewire.on('confirm-uncheck', (event) => {
    //         if (confirm('Are you sure you want to mark this as unpaid?')) {
    //             Livewire.dispatch('uncheckItem', { itemId: event.itemId });
    //         }
    //     });
    // });
</script>
    <script>
        function printDiv(divId) {
            const printContents = document.getElementById(divId).innerHTML;
            const originalContents = document.body.innerHTML;
            
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>