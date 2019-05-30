@can('accept', $model)
<a title="Mark this as best answer" 
class="vote-accept {{$model->status}} mt-2"
onclick="event.preventDefault(); document.getElementById('accept-answer-{{$model->id}}').submit()">
    <i class="fas fa-check fa-2x"></i>
</a>
<form id="accept-answer-{{$model->id}}" action="{{ route('answers.accept', $model->id) }}"  method="POST" style="display:none">
    @csrf
</form>
@else
    @if($model->is_best)
        <a title="Accepted as best answer by question owner" class="vote-accept {{$model->status}} mt-2">
            <i class="fas fa-check fa-2x"></i>
        </a>
    @endif
@endcan