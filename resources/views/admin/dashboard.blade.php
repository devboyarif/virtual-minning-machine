<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
            <div>
                <a href="{{ route('vmm.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create VMM</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
                        VMM List
                    </h2>
                    <table class="min-w-full bg-white border border-gray-200 shadow-md">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lifetime</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Minimum Invest</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Distribute Coin</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Execution Time</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preparation Time</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($vmms as $vmm)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vmm->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vmm->lifetime }} minutes</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">৳{{ $vmm->minimum_invest }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vmm->distribute_coin }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vmm->execution_time }} seconds</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vmm->preparation_time }} minutes</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Carbon\Carbon::parse($vmm->start_time)->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($vmm->type === 'draft')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Draft
                                            </span>
                                        @elseif ($vmm->type === 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @elseif ($vmm->type === 'in_preparation')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                In Preparation
                                            </span>
                                        @elseif ($vmm->type === 'running')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Running
                                            </span>
                                        @elseif ($vmm->type === 'finished')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Completed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($vmm->type === 'draft')
                                            <form action="{{ route('vmm.status', $vmm->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit" class="underline">
                                                    Make Active
                                                </button>
                                            </form>
                                        @elseif ($vmm->type === 'active')
                                            <form action="{{ route('vmm.status', $vmm->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="draft">
                                                <button type="submit" class="underline">
                                                    Make Draft
                                                </button>
                                            </form>
                                        @elseif ($vmm->type === 'finished')
                                            <form action="{{ route('vmm.status', $vmm->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit" class="underline">
                                                    Make Active
                                                </button>
                                            </form>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center" colspan="4">No vmm found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>
