<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="mr-2">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Programs') }}
                </h2>
            </div>
            @auth
                @can('edit programs')
                <div class="mx-2">
                    <a class="font-semibold text-xl text-gray-800 leading-tight border-2 px-2 py-1 rounded-md" href="{{ route("createProgramView") }}">Create Program</a>
                </div>
                @endcan
            @endauth
        </div>
    </x-slot>

    @php
        $isEmpty = empty($sortType) || empty($sortColumn);
        $isSortByPrograms = $isEmpty || ($sortType == 'desc' && $sortColumn == 'programs') || $sortColumn != 'programs';
        $isSortByCategories = $isEmpty || ($sortType == 'desc' && $sortColumn == 'categories') || $sortColumn != 'categories';
        $isSortByTypes = $isEmpty || ($sortType == 'desc' && $sortColumn == 'types') || $sortColumn != 'types';
        $isSortByRating = $isEmpty || ($sortType == 'asc' && $sortColumn == 'rating') || $sortColumn != 'rating';
    @endphp

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('sortedPrograms', 'programs-'.($isSortByPrograms ? 'asc' : 'desc')) }}">Program name</a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('sortedPrograms', 'categories-'.($isSortByCategories ? 'asc' : 'desc')) }}">Category</a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('sortedPrograms', 'types-'.($isSortByTypes ? 'asc' : 'desc')) }}">Type</a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('sortedPrograms', 'rating-'.($isSortByRating ? 'desc' : 'asc')) }}">Rating</a>
                                </th>
                                @auth
                                    @can('edit programs')
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Edit
                                        </th>
                                    @endcan
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($programs as $program)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-900">
                                    <a href="{{ route('programView', $program->id) }}">{{ $program->name }}</a>
                                    
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @foreach($program->categories as $category)
                                        {{ $category->name }}
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $program->type->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $program->rating }}
                                </td>
                                @auth
                                    @can('edit programs')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <a href="{{ route('program', $program->id) }}">Edit</a>
                                        </td>
                                    @endcan
                                @endauth
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">empty</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    {{ $programs->links() }}
</x-app-layout>
