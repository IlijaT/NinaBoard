
<div class="bg-white p-5 card" style="height: 200px">
    <h3 class="font-normal mb-3 text-xl py-2 -ml-12 border-l-4 border-blue-light pl-4">
        <a style="text-decoration: none" class="text-black" href="{{ $project->path() }}">{{ $project->title }} </a>
    </h3>
    <div class="text-grey">{{ str_limit($project->description, 100) }}</div>
</div>
 