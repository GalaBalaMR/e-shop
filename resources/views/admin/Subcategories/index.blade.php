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
                    <th>Kategória</th>
                    <th>Vytvorená</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Meno</th>
                    <th>Opis</th>
                    <th>Kategória</th>
                    <th>Vytvorená</th>
                </tr>
            </tfoot>
            <tbody>
                @forelse ($subcategories as $subcategory)
                    <tr>
                        <td>{{ $subcategory->id }}</td>
                        <td>{{ $subcategory->name }}</td>
                        <td>{{ $subcategory->description }}</td>
                        <td>{{ $subcategory->category->name }}</td>
                        <td>{{ $subcategory->created_at }}</td>
                        <td>
                            <form action="{{ route('admin.subcategories.destroy', $subcategory->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-close"></button>
                            </form>
                            <a href="{{ route('admin.subcategories.edit', $subcategory->id) }}" class="link-success text-decoration-none m-auto">Editovať</a>
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