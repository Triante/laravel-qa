<a title="{{$model->is_favorited ? 'Unmark question as favorite' : 'Mark question as favorite'}}" 
    class="favorite mt-2 {{Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '')}}"
    onclick="event.preventDefault(); document.getElementById('favorite-question-{{$model->id}}').submit()">
        <i class="fas fa-star fa-2x"></i>
    <span class="favorites-count">{{$model->favorites_count." ".str_plural('Favorite', $model->favorites_count)}}</span>
</a>
<form id="favorite-question-{{$model->id}}" action="/questions/{{$model->id}}/favorites"  method="POST" style="display:none">
    @csrf
    @if($model->is_favorited) 
        @method('DELETE')
    @endif
</form>