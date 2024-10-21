<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create VMM
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                    <form action="{{ route('vmm.store') }}" class="max-w-sm mx-auto" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                            <input type="text" id="title" name="title" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter title" required />
                        </div>

                        <div class="mb-5">
                            <label for="lifetime" class="block mb-2 text-sm font-medium text-gray-900">Lifetime (in minutes)</label>
                            <input type="number" id="lifetime" name="lifetime" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter lifetime" required />
                        </div>

                        <div class="mb-5">
                            <label for="minimum_invest" class="block mb-2 text-sm font-medium text-gray-900">Minimum Investment</label>
                            <input type="number" id="minimum_invest" name="minimum_invest" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter minimum investment" required />
                        </div>

                        <div class="mb-5">
                            <label for="distribute_coin" class="block mb-2 text-sm font-medium text-gray-900">Distribute Coin</label>
                            <input type="number" id="distribute_coin" name="distribute_coin" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter distribute coin" required />
                        </div>

                        <div class="mb-5">
                            <label for="execution_time" class="block mb-2 text-sm font-medium text-gray-900">Execution Time (in seconds)</label>
                            <input type="number" id="execution_time" name="execution_time" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter execution time" required />
                        </div>

                        <div class="mb-5">
                            <label for="preparation_time" class="block mb-2 text-sm font-medium text-gray-900">Preparation Time (in minutes)</label>
                            <input type="number" id="preparation_time" name="preparation_time" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter preparation time" required />
                        </div>

                        <div class="mb-5">
                            <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">Start Time</label>
                            <input type="datetime-local" id="start_time" name="start_time" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                        </div>

                        <div class="mb-5">
                            <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type</label>
                            <select id="type" name="type" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="draft">Draft</option>
                                <option value="active">Active</option>
                            </select>
                        </div>

                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Create VMM</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
