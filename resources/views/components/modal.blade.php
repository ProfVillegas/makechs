<div class="fixed inset-0 z-50 overflow-y-auto" x-show="open">
    <!-- Fondo oscuro -->
    <div class="fixed inset-0 opacity-50"></div>
    
    <!-- Contenido del modal -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <!-- Header -->
            <div class="border-b px-6 py-4">
                <h3 class="text-xl font-semibold">
                    {{ $title ?? 'Modal' }}
                </h3>
            </div>
            
            <!-- Body (slot principal) -->
            <div class="p-6">
                {{ $slot }}
            </div>
            
            <!-- Footer (slot con nombre) -->
            @if(isset($footer))
            <div class="border-t px-6 py-4 bg-gray-50 rounded-b-lg">
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>
</div>