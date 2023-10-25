<h1>Products Page</h1>


@foreach($products as $product) 
    <div>
        {{ $product->name }} : {{ $product->price }}
    </div>
@endforeach