@extends('admin.index')
@section('main')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Zoznam upozornení 
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Subjekt</th>
                    <th>Druh</th>
                    <th>Správa</th>
                    <th>link</th>
                    <th>Dátum</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>id</th>
                    <th>Subjekt</th>
                    <th>Druh</th>
                    <th>Správa</th>
                    <th>link</th>
                    <th>Dátum</th>
                </tr>
            </tfoot>
            <tbody>
                @forelse ($messages as $message)
                    <tr>
                        <td>{{ $message->id }}</td>
                        <td>{{ $message->name }}</td>
                        <td>
                            <a href="{{ route('admin.'.Str::plural($message->about).'.show', $message->about_id) }}"
                            class="link link-success text-decoration-none">
                                {{ $message->about }}
                            </a>
                        </td>
                        <td>{{ $message->content }}</td>
                        <td>{{ Str::plural($message->about) }}</td>
                        <td>{{ $message->created_at }}</td>
                        <td>
                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-close"></button>
                            </form>
                            <a href="{{ route('admin.messages.edit', $message->id) }}" class="link-success text-decoration-none m-auto">Editovať</a>
                        </td>
                    </tr>
                    
                @empty
                    <tr>Žiadne nové správy</tr>
                @endforelse
                
            </tbody>
        </table>
    </div>
</div>
@endsection