<div class="people-list" id="people-list">
    <ul class="list">
        @foreach($threads as $inbox)
            @if(!is_null($inbox->thread))
            <li class="clearfix" style="background: #f7f8fc; margin-bottom: 2px;padding: 20px;margin-right: 2px;">
                <a href="{{route('message.read', ['id'=>$inbox->withUser->id])}}">
                <img src="{{asset('images/' . $inbox->withUser->image)}} " alt="avatar" style="width: 50px;height: 50px;object-fit: cover;border-radius: 50%;"  />
                <div class="about">
                    <div class="name">{{$inbox->withUser->name}}</div>
                    <div class="status">
                        @if(auth()->user()->id == $inbox->thread->sender->id)
                            <span class="fa fa-reply"></span>
                        @endif
                        <span>{{substr($inbox->thread->message, 0, 20)}}</span>
                    </div>
                </div>
                </a>
            </li>
            @endif
        @endforeach
    </ul>
</div>
