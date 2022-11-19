@extends('admin.index')
@section('main')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Zoznam položiek
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Meno</th>
                    <th>Opis</th>
                    <th>Cena</th>
                    <th>Pridaný</th>
                    <th>Možnosti</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Meno</th>
                    <th>Opis</th>
                    <th>Cena</th>
                    <th>Pridaný</th>
                    <th>Možnosti</th>
                </tr>
            </tfoot>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->short_description }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <form action="{{ route('admin.categories.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-close"></button>
                            </form>
                            <a href="{{ route('admin.items.edit', $item->id) }}" class="link-success decoration-none m-auto">Editovať</a>
                        </td>
                    </tr>
                    
                @empty
                    <tr>Nie je pridaný žiadny produkt</tr>
                @endforelse
                
            </tbody>
        </table>
    </div>
</div>
@endsection