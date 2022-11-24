@extends('admin.index')
@section('main')
<div class="container-fluid px-4">
    
    <h1 class="mt-4">Admin panel</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Upozornenia</li>
    </ol>
    <div class="row">
        @forelse ($messages as $message)
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h1 class="display-6">{{ $message->name }}</h1>
                    <p>{{ $message->content }}</p>
                </div>
                {{-- streched link for error --}}
                <a class="small text-white stretched-link" href="{{ route('admin.'.$message->about .'s.show', $message->about_id ) }}"></a>
                
            </div>
        </div>
            
        @empty
            <p>Nie sú žiadne nové správy.</p>
        @endforelse
        
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4" style="height: 400px">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Objednávky
                </div>

                {!! $chart->container() !!}
            </div>
        </div>
        
    </div>
</div>
@endsection