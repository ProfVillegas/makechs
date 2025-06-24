<div>
    <x-button wire:click="openModal" class="mb-4">Nuevo Autor</x-button>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Apellido Paterno</th>
                    <th class="px-6 py-3 text-left">Apellido Materno</th>
                    <th class="px-6 py-3 text-left">Redes Sociales</th>
                    <th class="px-6 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($authors as $author)
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 dark:text-gray-300">{{ $author->name }}</td>
                    <td class="px-6 py-4 dark:text-gray-300">{{ $author->lastname }}</td>
                    <td class="px-6 py-4 dark:text-gray-300">{{ $author->slastname }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            @if($author->equis)
                            <a href="{{ $author->equis }}" target="_blank" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                <x-heroicon-s-chat-bubble-left-right class="w-5 h-5" />
                            </a>
                            @endif
                            @if($author->instagram)
                            <a href="{{ $author->instagram }}" target="_blank" class="text-pink-500 hover:text-pink-700">
                                <x-heroicon-s-camera class="w-5 h-5" />
                            </a>
                            @endif
                            @if($author->tiktok)
                            <a href="{{ $author->tiktok }}" target="_blank" class="text-black hover:text-gray-700 dark:hover:text-gray-300">
                                <x-heroicon-s-musical-note class="w-5 h-5" />
                            </a>
                            @endif
                            @if($author->youtube)
                            <a href="{{ $author->youtube }}" target="_blank" class="text-red-500 hover:text-red-700">
                                 <x-heroicon-s-video-camera class="w-5 h-5" />
                            </a>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <button wire:click="openModal({{ $author->id }})" 
                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                            Editar
                        </button>
                        <button wire:click="delete({{ $author->id }})" 
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                onclick="return confirm('¿Eliminar autor?')">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $authors->links() }}
    </div>

    <!-- Modal para Autor -->
     @if($showModal)
    <x-modal wire:model="showModal" maxWidth="2xl">
        <x-slot name="title">
            {{ $authorId ? 'Editar Autor' : 'Nuevo Autor' }}
        </x-slot>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Nombre" wire:model="form.name" />
            <x-input label="Apellido Paterno" wire:model="form.lastname" />
            <x-input label="Apellido Materno" wire:model="form.slastname" />
            <x-input label="Enlace Equis (X)" wire:model="form.equis" placeholder="https://..." />
            <x-input label="Instagram" wire:model="form.instagram" placeholder="https://..." />
            <x-input label="TikTok" wire:model="form.tiktok" placeholder="https://..." />
            <x-input label="YouTube" wire:model="form.youtube" placeholder="https://..." />
            <x-input label="Sitio Web" wire:model="form.website" placeholder="https://..." />
        </div>
        
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-button secondary wire:click="$set('showModal', false)">
                    Cancelar
                </x-button>
                <x-button wire:click="save">
                    {{ $authorId ? 'Actualizar' : 'Guardar' }}
                </x-button>
            </div>
        </x-slot>
    </x-modal>
    @endif
</div>