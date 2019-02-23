<div class="flex flex-col h-full bg-white p-4 card h-64">
    
        <h3 class="font-normal mb-2 text-lg py-2 -ml-6 border-l-4 border-blue-light pl-2">
            <a style="text-decoration: none" class="text-black" href="{{ $project->path() }}">
                {{ str_limit($project->title, 60) }} </a>
            <span class="text-grey text-xs">  {{$project->created_at->toFormattedDateString()}}</span>
        </h3>
        
        <div class="flex-1 text-grey text-xs mb-2">
            {{ str_limit($project->description, 220) }}
        </div>
        
        @can('delete-project')
        <footer>
            <form method="POST" action="{{ $project->path() }}" class="text-right">
                @method('DELETE')
                @csrf
                <button type="submit" class="no-underline text-orange hover:text-orange-dark rounded-lg py-2 px-3 border border-black text-xs">Delete</button>
            </form>
        </footer>
        @endcan

   
</div>
