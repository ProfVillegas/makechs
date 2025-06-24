<?php
use function Livewire\Volt\{state, rules, mount};
use App\Models\Post;
use App\Models\Author;

state([
    'author' => null,
    'posts' => [],
    'showPostModal' => false,
    'currentPost' => null,
    'form' => [
        'name' => '',
        'subtitle' => '',
        'abstract' => '',
        'note' => ''
    ]
]);

rules([
    'form.name' => 'required|min:5',
    'form.subtitle' => 'nullable|min:5',
    'form.abstract' => 'nullable|min:10',
    'form.note' => 'nullable|min:5'
]);

// Cargar posts al seleccionar autor
mount(function (Author $author) {
    $this->author = $author;
    $this->loadPosts();
});

$loadPosts = fn() => $this->posts = $this->author->posts()->orderBy('created_at', 'desc')->get();

$openPostModal = function ($postId = null) {
    $this->reset('form');
    $this->showPostModal = true;
    $this->currentPost = null;
    
    if ($postId) {
        $this->currentPost = Post::find($postId);
        $this->form = $this->currentPost->only(['name', 'subtitle', 'abstract', 'note']);
    }
};

$savePost = function () {
    $this->validate();
    
    if ($this->currentPost) {
        $this->currentPost->update($this->form);
    } else {
        Post::create([
            'author_id' => $this->author->id,
            'name' => $this->form['name'],
            'subtitle' => $this->form['subtitle'],
            'abstract' => $this->form['abstract'],
            'note' => $this->form['note']
        ]);
    }
    
    $this->showPostModal = false;
    $this->loadPosts();
};

$deletePost = function ($postId) {
    Post::destroy($postId);
    $this->loadPosts();
};
?>

<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold dark:text-gray-300">Posts de {{ $author->name }}</h2>
        <x-button wire:click="openPostModal">Nuevo Post</x-button>
    </div>

    <div class="space-y-4">
        @foreach($posts as $post)
        <div class="border dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-bold text-lg dark:text-gray-300">{{ $post->name }}</h3>
                    @if($post->subtitle)
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $post->subtitle }}</p>
                    @endif
                </div>
                <div class="flex space-x-2">
                    <button wire:click="openPostModal({{ $post->id }})" 
                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <x-icon name="pencil" class="w-5 h-5" />
                    </button>
                    <button wire:click="deletePost({{ $post->id }})" 
                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                            onclick="return confirm('¿Eliminar post?')">
                        <x-icon name="trash" class="w-5 h-5" />
                    </button>
                </div>
            </div>
            
            @if($post->abstract)
            <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="font-medium text-gray-700 dark:text-gray-300">Abstract</h4>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $post->abstract }}</p>
            </div>
            @endif
            
            @if($post->note)
            <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                <h4 class="font-medium text-gray-700 dark:text-gray-300">Nota</h4>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $post->note }}</p>
            </div>
            @endif
            
            <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                {{ $post->created_at->format('d M Y, H:i') }}
            </div>
        </div>
        @endforeach
        
        @if(count($posts) === 0)
        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
            <x-icon name="document-text" class="w-12 h-12 mx-auto text-gray-400" />
            <p class="mt-3">No hay posts disponibles</p>
        </div>
        @endif
    </div>

    <!-- Modal para Posts -->
    <x-modal wire:model="showPostModal" maxWidth="3xl">
        <x-slot name="title">
            {{ $currentPost ? 'Editar Post' : 'Nuevo Post' }}
        </x-slot>
        
        <div class="space-y-4">
            <x-input label="Título" wire:model="form.name" />
            <x-input label="Subtítulo" wire:model="form.subtitle" />
            <x-textarea label="Abstract" wire:model="form.abstract" rows="4" />
            <x-textarea label="Nota" wire:model="form.note" rows="3" />
        </div>
        
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-button secondary wire:click="$set('showPostModal', false)">
                    Cancelar
                </x-button>
                <x-button wire:click="savePost">
                    {{ $currentPost ? 'Actualizar' : 'Guardar' }}
                </x-button>
            </div>
        </x-slot>
    </x-modal>
</div>