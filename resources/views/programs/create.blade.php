<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create program') }}
        </h2>
    </x-slot>

    <div class="hidden sm:block" aria-hidden="true">
        <div class="py-5">
            <div class="border-t border-gray-200"></div>
        </div>
    </div>
    <script>
        function handler() {
            return {
              fields: [],
              addNewField() {
                  this.fields.push({
                      url: '',
                      urlTitle: ''
                   });
                },
                removeField(index) {
                   this.fields.splice(index, 1);
                 }
              }
         }
    </script>
    <div class="mt-10 sm:mt-0">
        <div class="mt-5 md:mt-0">
            <form action="{{ route('createProgram') }}" method="POST">
                @csrf
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="program-name">
                                  Program name
                                </label>
                                <input 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                    id="category" 
                                    type="text"
                                    name="program-name"
                                    placeholder="Sponsor block"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">
                                    Type
                                </label>
                                <select 
                                    id="type" 
                                    name="type" 
                                    autocomplete="type" 
                                    class="shadow appearance-none border rounded w-full pt-1 pb-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline"
                                    
                                >
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                                      Category
                                    </label>
                                    <input 
                                        list="suggestions-categoties" 
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                        id="category" 
                                        type="text"
                                        name="category-name"
                                        placeholder="For every day"
                                    >
                                    <datalist id="suggestions-categoties">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->name }}"/>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-6 flex flex-wrap " x-data="handler()">
                                <div class="relative flex-grow max-w-full flex-1 px-4">
                                <table class="w-full max-w-full mb-4 bg-transparent table-bordered items-center p-1">
                                  <thead class="thead-light">
                                   <tr>
                                     <th>#</th>
                                     <th>Url</th>
                                     <th>Title for url</th>
                                     <th>Remove</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <template x-for="(field, index) in fields" :key="index">
                                     <tr>
                                      <td x-text="index + 1"></td>
                                      <td><input x-model="field.url" type="text" name="urls[]" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"></td>
                                      <td><input x-model="field.urlTitle" type="text" name="urlTitles[]" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"></td>
                                      <td><button type="button" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-red-600 text-white hover:bg-red-700 btn-small" @click="removeField(index)">&times;</button></td>
                                    </tr>
                                   </template>
                                  </tbody>
                                  <tfoot>
                                     <tr>
                                       <td colspan="4" class="text-right">
                                           <button 
                                               type="button" 
                                               class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-500 text-white hover:bg-blue-600" 
                                               @click="addNewField()"
                                           >
                                               + Add Url
                                           </button>
                                       </td>
                                    </tr>
                                  </tfoot>
                                </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>  
</x-app-layout>
