<div class="bg-white p-4 card mt-3" >
    <ul class="text-xs list-reset">
        @foreach($project->activities as $activity)
            <li class="{{$loop->last ? '' : 'mb-1'}}">
                @include("projects.activity.{$activity->description}")
                <span class="text-grey">{{ $activity->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>

</div>