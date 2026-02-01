<?php

namespace App\Livewire\Admin;

use App\Models\SavingType;
use Livewire\Component;
use Livewire\WithPagination;

class ProductManagement extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $productId;
    public $name;
    public $description;
    public $min_amount;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'min_amount' => 'required|numeric|min:0',
    ];

    public function render()
    {
        $products = SavingType::when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount('transactions')
            ->paginate(10);

        return view('livewire.admin.product-management', [
            'products' => $products,
        ])->layout('components.layouts.admin', ['title' => 'Manajemen Produk Tabungan']);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editMode = false;
        $this->productId = null;
        $this->name = '';
        $this->description = '';
        $this->min_amount = '';
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $product = SavingType::findOrFail($this->productId);
            $product->update([
                'name' => $this->name,
                'description' => $this->description,
                'min_amount' => $this->min_amount,
            ]);
            session()->flash('message', 'Produk tabungan berhasil diperbarui!');
        } else {
            SavingType::create([
                'name' => $this->name,
                'description' => $this->description,
                'min_amount' => $this->min_amount,
            ]);
            session()->flash('message', 'Produk tabungan berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $product = SavingType::findOrFail($id);
        $this->editMode = true;
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->min_amount = $product->min_amount;
        $this->showModal = true;
    }

    public function delete($id)
    {
        SavingType::findOrFail($id)->delete();
        session()->flash('message', 'Produk tabungan berhasil dihapus!');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
