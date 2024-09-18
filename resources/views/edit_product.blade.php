<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as ")   }}{{ $user->is_admin ? 'Admin!' : $user->name }}
                </div>
            </div>
        </div>
    </div>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
          
                    <form method="post" action="{{ route('update_product') }}">
                        <input type="hidden" name="update_id" value="{{$product->id}}">
                    @csrf
                    @method('PUT')
                        <table>
                            <tr>
                                <td>
                                <label>Name of Product</label>
                                </td>
                                <td>
                                <input type="text" name="name" value="{{ $product->name }}" >
                                </td>
                            </tr>
                            <tr>
                            <td>
                                <label>Price of Product</label>
                                </td>
                                <td>
                                <input type="text" name="price" value="{{ $product->price }}">
                                </td>
                            </tr>
                            <tr>
                            <td colspan="2">
                            <input type="submit" value="Update" style="background-color:green;color:white;width:100%;">
                                </td>
                                
                            </tr>
                        </table>
                        
                        
                        
                    </form> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
