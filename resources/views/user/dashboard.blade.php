<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="d-flex text-gray-900">
                    {{-- Investment Modal --}}
                    <div id="investmentModal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-opacity-50 bg-black backdrop-blur-sm">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <form action="{{ route('invest.now') }}" method="POST">
                                @csrf
                                <input type="hidden" name="vmm_id" id="vmm_id">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Invest to VMM</h3>
                                        <button id="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <div class="p-4 md:p-5 space-y-4">
                                        <div class="mb-5">
                                            <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount (৳)</label>
                                            <input type="text" id="amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="amount"/>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                        <button id="acceptModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- VMM Card --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 m-4">
                        @foreach ($vmms as $vmm)
                            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-md p-6">
                                <h2 class="text-center text-xl font-bold mb-4">
                                    {{ $vmm->title }}
                                </h2>
                                <div class="text-center mb-5">
                                    @if ($vmm->type === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @elseif ($vmm->type === 'in_preparation')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            InPreparation
                                        </span>
                                    @elseif ($vmm->type === 'running')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-300 text-yellow-800">
                                            Running
                                        </span>
                                    @elseif ($vmm->type === 'finished')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Finished
                                        </span>
                                    @endif
                                </div>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li class="flex items-center">
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path></svg>
                                        Start at {{ $vmm->start_time }}
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path></svg>
                                        Execution/Running time {{ $vmm->execution_time }} seconds
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path></svg>
                                        Distribute Coins: {{ $vmm->distribute_coin }}
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path></svg>
                                        Minimum invest : ৳{{ $vmm->minimum_invest }}
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path></svg>
                                        Preparation time : {{ $vmm->preparation_time }} Minutes
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path></svg>
                                        My investment : ৳{{ $vmm?->my_investment }}
                                    </li>
                                </ul>

                                @if ($vmm->type === 'active')
                                    <div class="flex justify-center mt-6">
                                        <button class="invest-btn bg-blue-500 text-white font-semibold py-2 px-4 rounded mt-4" type="button"
                                            data-vmmid="{{ $vmm->id }}">
                                            Invest Now
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get modal elements
            const modal = document.getElementById('investmentModal');
            const amountInput = document.getElementById('amount'); // Example of using the amount input field

            // Add click event listener to all invest buttons
            const investButtons = document.querySelectorAll('.invest-btn');
            investButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const vmmId = this.getAttribute('data-vmmid');

                    modal.classList.remove('hidden');
                    document.getElementById('vmm_id').value = vmmId;
                });
            });

            // Close modal
            const closeModalButton = document.getElementById('closeModal');
            closeModalButton.addEventListener('click', function () {
                modal.classList.add('hidden');
            });

            // If you want the modal to close when clicking outside the modal content
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
