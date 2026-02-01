<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use Livewire\Component;
use Livewire\WithPagination;

class AcademicYearManagement extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $yearId;
    public $name;
    public $start_date;
    public $end_date;
    public $is_active = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $years = AcademicYear::latest()->paginate(10);

        return view('livewire.admin.academic-year-management', [
            'years' => $years,
        ])->layout('components.layouts.admin', ['title' => 'Manajemen Tahun Akademik']);
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
        $this->yearId = null;
        $this->name = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->is_active = false;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $year = AcademicYear::findOrFail($this->yearId);
            $year->update([
                'name' => $this->name,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Tahun akademik berhasil diperbarui!');
        } else {
            AcademicYear::create([
                'name' => $this->name,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Tahun akademik berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $year = AcademicYear::findOrFail($id);
        $this->editMode = true;
        $this->yearId = $year->id;
        $this->name = $year->name;
        $this->start_date = $year->start_date->format('Y-m-d');
        $this->end_date = $year->end_date->format('Y-m-d');
        $this->is_active = $year->is_active;
        $this->showModal = true;
    }

    public function setActive($id)
    {
        $year = AcademicYear::findOrFail($id);
        $year->update(['is_active' => true]);
        session()->flash('message', 'Tahun akademik ' . $year->name . ' telah diaktifkan!');
    }

    public function delete($id)
    {
        AcademicYear::findOrFail($id)->delete();
        session()->flash('message', 'Tahun akademik berhasil dihapus!');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
