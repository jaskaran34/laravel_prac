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
                    <h3 style="color:blue;margin-bottom:10px;">Products List</h3>
                @if (session()->has('success_delete'))
    <div class="alert alert-success">
        {{ session()->get('success_delete') }}
    </div>
@endif
@if (session()->has('Error_delete'))
    <div class="alert alert-danger">
        {{ session()->get('Error_delete') }}
    </div>
@endif
                    <style>
                        .product-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.product-table th, .product-table td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
}

.product-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.product-table th {
    background-color: #4CAF50;
    color: white;
}
                        </style>
                <table class="product-table">
    <thead>
        <tr>
        <th>Id</th>    
        <th>Name of Product</th>
            <th>Price</th>
            <th>Added By</th>
            <th>Created At</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <script type="text/javascript">
            function delete_product(id){
               document.getElementById('delete_id').value=id;
               document.delete_form.submit()
            }
            function edit_product(id)
            {
                document.getElementById('edit_id').value=id;
               document.edit_form.submit();
                
            }
            </script>

        @foreach ($products as $product)
            <tr>
            <td>{{ $product->id }}</td>    
            <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->user->name }}</td>
                <td>{{ $product->created_at->diffForHumans() }}</td>
                <td><input type="button" value="Edit" style="width: 100%;background-color:blue;color:white;"
                onclick="edit_product({{ $product->id }})" > </td>
                <td><input type="button" value="Delete" style="width: 100%;background-color:red;color:white;"
                onclick="delete_product({{$product->id }})" > </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{$products->links()}}
<form method="POST" action="{{ route('delete_product')}}" name="delete_form">
    @csrf 
    @method('DELETE')
<input type="hidden" value="" id="delete_id" name="delete_id">
   

</form>

<form method="POST" action="{{ route('edit_product')}}" name="edit_form">
    @csrf 
    @method('PUT')
<input type="hidden" value="" id="edit_id" name="edit_id">
   

</form>
                </div>
            </div>
        </div>
    </div>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@if (session()->has('Error'))
    <div class="alert alert-danger">
        {{ session()->get('Error') }}
    </div>
@endif
                    <form method="post" action="{{ route('add_product') }}">
                    @csrf
                        <table>
                            <tr>
                                <td>
                                <label>Name of Product</label>
                                </td>
                                <td>
                                <input type="text" name="name" >
                                </td>
                            </tr>
                            <tr>
                            <td>
                                <label>Price of Product</label>
                                </td>
                                <td>
                                <input type="text" name="price" >
                                </td>
                            </tr>
                            <tr>
                            <td colspan="2">
                            <input type="submit" value="Add" style="background-color:wheat;color:blue;width:100%;">
                                </td>
                                
                            </tr>
                        </table>
                        
                        
                        
                    </form> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
