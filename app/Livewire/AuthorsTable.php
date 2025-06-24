<?php
namespace App\Livewire;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Author;

class AuthorsTable extends Component
{
    use WithPagination;

    public $showModal = false;
    public $authorId;
    public $form = [
        'name' => '',
        'lastname' => '',
        'slastname' => '',
        'equis' => '',
        'instagram' => '',
        'tiktok' => '',
        'youtube' => '',
        'website' => ''
    ];

    protected $rules = [
        'form.name' => 'required|min:3',
        'form.lastname' => 'required|min:2',
        'form.slastname' => 'required|min:2',
        'form.equis' => 'nullable|url',
        'form.instagram' => 'nullable|url',
        'form.tiktok' => 'nullable|url',
        'form.youtube' => 'nullable|url',
        'form.website' => 'nullable|url'
    ];

    public function updatedAuthorId()
    {
        // Si necesitas validación dinámica para algún campo único
    }

    public function openModal($id = null)
    {
        $this->resetErrorBag();
        $this->authorId = $id;
        $this->reset('form');
        
        if ($id) {
            $author = Author::find($id);
            $this->form = $author->only([
                'name', 'lastname', 'slastname', 'equis', 'instagram', 
                'tiktok', 'youtube', 'website'
            ]);
        }
        
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();
        
        if ($this->authorId) {
            Author::find($this->authorId)->update($this->form);
        } else {
            Author::create($this->form);
        }
        
        $this->showModal = false;
        session()->flash('message', 'Autor guardado exitosamente');
    }

    public function delete($id)
    {
        Author::destroy($id);
        session()->flash('message', 'Autor eliminado');
    }

    public function render()
    {
        return view('livewire.authors-table', [
            'authors' => Author::paginate(10)
        ]);
    }
}