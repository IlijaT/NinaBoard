<div>
    <ul class="text-xs list-reset">
        @if(isset($activities))
            @foreach($activities as $activity)
                <li class="{{$loop->last ? '' : 'mb-1'}}">
                    @include("projects.activity.{$activity->description}")
                    <span class="text-grey text-xs">{{ $activity->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        @else
        @foreach($project->activities as $activity)
            <li class="{{$loop->last ? '' : 'mb-1'}}">
                @include("projects.activity.{$activity->description}")
                <span class="text-grey">{{ $activity->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
        @endif
    </ul>

</div>