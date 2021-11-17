<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Program') }}
        </h2>
    </x-slot>

    <div class="hidden sm:block" aria-hidden="true">
        <div class="py-5">
            <div class="border-t border-gray-200"></div>
        </div>
    </div>
    
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
          {{ $program->name }}
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
          {{ $program->type->name  }}
        </p>
      </div>
      <div class="border-t border-gray-200">
        <dl>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Categories
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
              @foreach ($program->categories as $category)
                <span> {{ $category->name }}</span>
              @endforeach
            </dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Links
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
              @foreach ($program->links as $link)
                <a href="{{ $link->link }}" target="_blank">
                  <span class="text-blue-500"> {{ $link->title }}</span>
                </a><br/>
              @endforeach
            </dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Rating
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
              {{ $program->getAvgRate() }}
            </dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Description
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
              Comming soon
            </dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Comments
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
              Comming soon
            </dd>
          </div>
        </dl>
      </div>
    </div>

</x-app-layout>
