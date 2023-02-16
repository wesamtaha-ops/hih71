@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset('chat/css/reset.css')}}">

    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="{{asset('chat/css/style.css')}}">
@endsection

@section('content')


        <div class="clearfix">
        @include('partials.peoplelist')
    
    <div class="chat">
      <div class="chat-header clearfix">
        @if(isset($user))
            <img src="{{asset('images/' . $user->image)}}" alt="avatar" style="width: 50px;height: 50px;object-fit: cover;border-radius: 50%;" />
        @endif
        <div class="chat-about">
            @if(isset($user))
                <div class="chat-with">{{'Chat with ' . @$user->name}}</div>
            @else
                <div class="chat-with">No Thread Selected</div>
            @endif
        </div>
      </div> <!-- end chat-header -->
      
      <div class="chat-history">
        <ul id="talkMessages">

            @foreach($messages as $message)
                @if($message->sender->id == auth()->user()->id)
                    <li class="clearfix" id="message-{{$message->id}}">
                        <div class="message-data align-right">
                            <span class="message-data-time" >{{$message->humans_time}} ago</span> &nbsp; &nbsp;
                            <span class="message-data-name" >{{$message->sender->name}}</span>
                        </div>
                        <div class="message other-message float-right">
                            {{$message->message}}
                        </div>
                    </li>
                @else

                    <li id="message-{{$message->id}}">
                        <div class="message-data">
                            <span class="message-data-name">{{$message->sender->name}}</span>
                            <span class="message-data-time">{{$message->humans_time}} ago</span>
                        </div>
                        <div class="message my-message">
                            {{$message->toHtmlString()}}
                        </div>
                    </li>
                @endif
            @endforeach


        </ul>

    </div> <!-- end chat-history -->

      
      <div class="chat-message clearfix">
      <form action="" method="post" id="talkSendMessage" style="display: flex; align-items: center">
            <textarea name="message-data" id="message-data" placeholder ="Type your message" rows="3" style="margin-bottom: 0px;"></textarea>
            <input type="hidden" name="_id" value="{{@request()->route('id')}}">
            <button type="submit" style="margin-left: 10px;">Send</button>
      </form>

      </div> <!-- end chat-message -->
      
    </div> <!-- end chat -->
    
  </div> <!-- end container -->

@endsection

@push('scripts')

<script>
          var __baseUrl = "{{url('/')}}"
      </script>
    
<script src='http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.0/handlebars.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js'></script>



        <script src="{{asset('chat/js/talk.js')}}"></script>

    <script>
        var show = function(data) {
            alert(data.sender.name + " - '" + data.message + "'");
        }

        var msgshow = function(data) {
            var html = '<li id="message-' + data.id + '">' +
            '<div class="message-data">' +
            '<span class="message-data-name">' + data.sender.name + '</span>' +
            '<span class="message-data-time">1 Second ago</span>' +
            '</div>' +
            '<div class="message my-message">' +
            data.message +
            '</div>' +
            '</li>';

            $('#talkMessages').append(html);

            var objDiv = $('.chat-history');
            objDiv.scrollTop(objDiv.height());
        }

    </script>
    {!! talk_live(['user'=>["id"=>auth()->user()->id, 'callback'=>['msgshow']]]) !!}

@endpush