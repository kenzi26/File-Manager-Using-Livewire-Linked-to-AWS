<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Document as ModelDocument;
use Illuminate\Support\Facades\File;

class Document extends Component
{
    public $totalDocuments;
    use WithPagination;
    public function pageinationView()
    {
        return 'custom-pagination-links-view';
    }
    public function render()
    {
        $documents = ModelDocument::orderBy('id', 'DESC')->paginate(3);
        $this->totalDocuments = ModelDocument::count();
        return view('livewire.admin.document', compact('documents'))->layout('layouts.admin-app');
    }

    public function delete($id)
    {
        $documents = ModelDocument::findOrFail($id);
        $path = public_path('storage\\') . $documents->document;
        if (File::exists($path)) {
            File::delete($path);
        }
        $result = $documents->delete();
        if ($result) {
            session()->flash('success', 'Document Delete Successfully');
        }
    }
}
