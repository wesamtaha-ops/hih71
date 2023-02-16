<li class="clearfix" id="message-{{$message->id}}">
    <div class="message-data align-right">
        <span class="message-data-time" >{{$message->humans_time}} ago</span> &nbsp; &nbsp;
        <span class="message-data-name" >{{$message->sender->name}}</span>
    </div>
    <div class="message other-message float-right">
        {{$message->message}}
    </div>
</li>
