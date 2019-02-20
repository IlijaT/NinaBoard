
<div class="bg-white p-5 card" style="height: 200px">
    <h3 class="font-normal mb-3 text-xl py-2 -ml-12 border-l-4 border-blue-light pl-4">
        
        <a style="text-decoration: none" class="text-black" href="{{ $project->path() }}">{{ $project->title }} </a>
        <span class="text-grey text-xs">  {{$project->created_at->toFormattedDateString()}}</span>
    </h3>
    <div class="text-grey text-xs mb-4">{{ str_limit($project->description, 150) }}</div>
    
    @can('delete-project')
    <footer>
        <form method="POST" action="{{ $project->path() }}" class="text-right">
            @method('DELETE')
            @csrf
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>
    @endcan
</div>
 