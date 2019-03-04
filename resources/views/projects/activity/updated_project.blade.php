@if (count($activity->changes['after']) == 1)
    {{ $activity->user->name }}  updated the <span class="italic text-xs"> {{ key($activity->changes['after']) }}</span>  of the announcement
@else
    {{ $activity->user->name }} updated the announcement
@endif