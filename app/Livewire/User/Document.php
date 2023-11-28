<?php

namespace App\Livewire\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Document as ModelDocument;

class Document extends Component
{
    public $title,
        $document,
        $edit_id,
        $edit_title,
        $new_document,
        $old_document,
        $showTable = true,
        $createForm = false,
        $updateForm = false;
    public $totalDocuments;
    use WithFileUploads;

    use WithPagination;
    public function pageinationView()
    {
        return 'custom-pagination-links-view';
    }
    public function render()
    {
        $documents = ModelDocument::orderBy('id', 'DESC')->where('user_id', Auth::user()->id)->paginate(4);
        $this->totalDocuments = ModelDocument::count();
        return view('livewire.user.document', compact('documents'))->layout('layouts.user-app');
    }

    public function goBack()
    {
        $this->showTable = true;
        $this->createForm = false;
        $this->updateForm = false;
    }

    public function showForm()
    {
        $this->showTable = false;
        $this->createForm = true;
    }

    public function create()
    {
        $document = new ModelDocument();
        $this->validate([
            'title' => ['required'],
            'document' => ['required'],
        ]);
        $filename = "";
        if ($this->document) {
            $filename = $this->document->store('documents', 'public');
        }
        $document->title = $this->title;
        $document->user_id = Auth::user()->id;
        $document->document = $filename;
        $result = $document->save();
        if ($result) {
            session()->flash('success', 'Document upload Successfully');
            $this->title = "";
            $this->document = "";
            $this->goBack();
        }
    }

    public function edit($id)
    {
        $this->showTable = false;
        $this->updateForm = true;
        $documents = ModelDocument::findOrFail($id);
        $this->edit_id = $documents->id;
        $this->edit_title = $documents->title;
        $this->old_document = $documents->document;
    }

    public function update($id)
    {
        $documents = ModelDocument::findOrFail($id);
        $this->validate([
            'edit_title' => ['required'],
        ]);
        $filename = "";
        if ($this->new_document) {
            $path = public_path('storage\\') . $documents->document;
            if (File::exists($path)) {
                File::delete($path);
            }
            $filename = $this->new_document->store('documents', 'public');
        } else {
            $filename = $this->old_document;
        }
        $documents->title = $this->edit_title;
        $documents->document = $filename;
        $result = $documents->save();
        if ($result) {
            session()->flash('success', 'Document Update Successfully');
            $this->edit_title = "";
            $this->new_document = "";
            $this->old_document = "";
            $this->goBack();
        }
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
