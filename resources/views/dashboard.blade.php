<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <br>
        <!-- Modal toggle -->
        <div class="flex">
            <div class="w-1/2 p-4 bg-white-800">
                <a href="{{route('linkedin.dashboard')}}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Conectarse
                    a Linkedin</a>
                <a href="{{route('media')}}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Conectarse
                    a Twitter</a>
            </div>
            <div class="w-1/2 p-4 bg-white-600">
                <button
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button" data-modal-toggle="authentication-modal">
                    Crear Post
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg content-center ...">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <caption
                            class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                            Publicaciones
                            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Horarios</p>
                        </caption>
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Red Social
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Comentario
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Hora
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Fecha
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Estado
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($publicaciones as $publicacion)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6">
                                    {{ $publicacion->redsocial}}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $publicacion->comment}}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $publicacion->hour}}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $publicacion->date}}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $publicacion->status}}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="#"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Main modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="authentication-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Publique su comentario:</h3>
                    <form class="space-y-6" method="post" action="post">
                        @csrf
                        <div>
                            <label for="text"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comentario</label>
                            <input type="text" name="comentario" id="comentario"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Comentario..." required>
                        </div>
                        <div>
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Red
                                Social</label>
                            <select id="redsocial" class="block mt-1 w-full" name="redsocial">
                                <option value="1">
                                    Linkedin
                                </option>
                                <option value="2">
                                    Twitter
                                </option>
                                <option value="3">
                                    Ambos
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="text"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Acción</label>
                            <select id="tipo" class="block mt-1 w-full" name="tipo">
                                <option value="1">
                                    Ahora
                                </option>
                                <option value="2">
                                    Añadir a la cola
                                </option>
                                <option value="3">
                                    Programar una hora
                                </option>
                            </select>
                        </div>
                        <div>
                            <input id="date" type="date" name="date" />
                            <input id="time" type="time" name="time" />
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crear
                            publicación</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>