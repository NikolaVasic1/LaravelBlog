@component('mail::message')

<p>{{$comment->user->firstname}} {{$comment->user->lastname}} wrote comment</p>
<p>{{$comment->content}}</p>
@component('mail::button', ['url' => url("/comments/$comment->id")])
Approve Comment
@endcomponent

@endcomponent
