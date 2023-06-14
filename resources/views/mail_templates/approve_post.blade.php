@component('mail::message')

<p>{{$post->user->firstname}} {{$post->user->lastname}} create a post</p>
<p>{{$post->title}}</p>
<p>{{$post->content}}</p>
@component('mail::button', ['url' => url("/posts/$post->id")])
Approve Post
@endcomponent

@endcomponent
