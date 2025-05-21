<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class Index extends Component
{
    use WithPagination;
    public $products;
    public $search = '';

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Product deleted successfully.'
        ]));
    }

    public function render()
    {
        $all_products = Product::with('category')
        ->where(function ($query) {
            // Apply search filters
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('price', 'like', '%' . $this->search . '%')
                ->orWhereHas('category', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        })
        ->latest()
        ->paginate(10);

        return view('livewire.product.index', compact('all_products'));
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function exportPdf()
    {
        $products = Product::with('category')->get();
        $pdf = Pdf::loadView('exports.products', compact('products'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'products.pdf');
    }

}
