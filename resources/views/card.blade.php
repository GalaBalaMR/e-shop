<body>

    <form action="{{ route('orders.store') }}" method="post">
        @csrf

    @foreach($items_data as $item)
        <li>{{ $item['item']['name'] }}</li>
        <input type="text" name="items[{{ $item['item']['id'] }}]" value="{{ json_encode( [  'item_id' => $item['item']['id'], 
                                                                    'item_pcs' => $item['pcs'], 
                                                                    'item_price' => $item['item']['price'],
                                                                    'item_full_price' => $item['fullPrice'] ]) }}">
    @endforeach
    <button type="submit">Odoslať</button>
</form>
    


</body>