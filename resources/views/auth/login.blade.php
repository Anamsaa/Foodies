<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-orange-50">
        <div class="w-full max-w-4xl bg-white rounded-3xl shadow-lg flex">
            
            {{-- Sección izquierda --}}
            <div class="w-1/2 bg-gray-800 text-white rounded-l-3xl flex flex-col justify-center items-center p-10">
                <h2 class="text-2xl font-bold mb-4">Welcome again<br>foodie :)</h2>
                <img src="/images/food-icon.png" alt="Foodies logo" class="w-24 h-24">
            </div>

            {{-- Formulario de login --}}
            <div class="w-1/2 p-10">
                <h1 class="text-3xl font-bold text-orange-500 mb-6">Iniciar sesión</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="'Correo electrónico'" />
                        <x-text-input id="email" type="email" name="email" class="w-full mt-1" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-6">
                        <x-input-label for="password" :value="'Contraseña'" />
                        <x-text-input id="password" type="password" name="password" class="w-full mt-1" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Botón -->
                    <div>
                        <x-primary-button class="bg-orange-400 hover:bg-orange-500 px-6 py-2">
                            Iniciar sesión
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
