@extends('admin.index')
@section('main')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Zoznam kategórií 
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Meno</th>
                    <th>Opis</th>
                    <th>Vytvorená</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Meno</th>
                    <th>Opis</th>
                    <th>Vytvorená</th>
                </tr>
            </tfoot>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-close"></button>
                            </form>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="link-success text-decoration-none m-auto">Editovať</a>
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