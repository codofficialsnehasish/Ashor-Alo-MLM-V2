<div class="mt-4">
    <div class="card">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-8">
                <div class="dt-buttons btn-group flex-wrap"> 
                    <select wire:model="perPage" class="form-control">
                        <option value="5">5 Rows</option>
                        <option value="10">10 Rows</option>
                        <option value="25">25 Rows</option>
                        <option value="50">50 Rows</option>
                    </select>
                </div>
        
                <div class="dt-buttons btn-group flex-wrap"> 
                    <button wire:click="exportExcel" class="btn btn-success btn-sm">Excel</button>
                    <button wire:click="exportPdf" class="btn btn-danger btn-sm">PDF</button>
                    <button onclick="window.print()" class="btn btn-primary btn-sm">Print</button>
                </div>
            </div>
        
            <div class="col-sm-12 col-md-4">
                <input wire:model.debounce.300ms="search" type="text" placeholder="Search..." class="form-control input-default" />
            </div>
            
        </div>
        

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    @foreach ($columns as $col)
                        <th class="text-uppercase">{{ str_replace('_', ' ', $col) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        @foreach ($columns as $col)
                            <td>{{ $record->$col }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) }}" class="text-center py-4" style="text-align: center !important;">No records found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="row mt-3">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" role="status" aria-live="polite">
                    Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of {{ $records->total() }} entries
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers d-flex justify-content-end">
                    {{ $records->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        
    </div>
</div>
