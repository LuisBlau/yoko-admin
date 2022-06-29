<!-- Right Sidebar -->
<div class="right-bar d-flex flex-column">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="fe-x noti-icon"></i>
        </a>
        <h4 class="m-0 text-white">Chat</h4>
    </div>
    <!-- User box -->
    <div class="row">
        <div class="col-6">
            <div class="user-box pb-2">
                <div class="user-img">
                    <img src="{{Auth::user()->avatar?Auth::user()->avatar:'../assets/images/users/person.jpg'}}" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                    <a href="javascript:void(0);" class="user-edit"></a>
                </div>
                
                <h5><a href="javascript: void(0);">{{Auth::user()->name}}</a> </h5>
                <p class="text-muted mb-0"><small>
                    @if(count($uroles)>1)
                    {{$uroles[0]->name." and ".(count($uroles)-1)." Roles"}}
                    @elseif(count($uroles) == 1)
                    {{$uroles[0]->name}}
                    @else
                    No Assigned Role
                    @endif
                </small></p>
            </div>    
        </div>
        <div class="col-6 d-flex flex-column" style="justify-content:center">
            <a href="{{ route('web.messages.index') }}" class="btn btn-primary" style="width:100px">Chat App</a>
        </div>
    </div>
    

    <ul class="nav nav-pills bg-light nav-justified">
        <li class="nav-item">
            <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link py-2 font-15 rounded-0 active">
                Unread
            </a>
        </li>
        <li class="nav-item">
            <a href="#messages1" data-toggle="tab" aria-expanded="false" class="nav-link py-2 font-15 rounded-0 chat-tab">
                Chat
            </a>
        </li>
    </ul>
    <div class="tab-content pl-3 pr-3">
        <div class="tab-pane show active" id="home1">
            <div class="h-100 d-flex flex-column">
                <div class="inbox-widget unread-list px-2">
                    
                </div>
            
                <div class="text-center mt-auto py-3" id="clear-all">
                    <a href="javascript:;" class="text-muted clearall" onclick="clearall()"> Clear All </a>
                </div>
            </div>
        </div>
        <div class="tab-pane show active" id="messages1">
            <div class="h-100 d-flex flex-column">
                <select id="selectRoom" class="form-control select2">
                    <option>Select Room</option>
                    <optgroup label="Rooms">
                        @foreach($rooms as $rid => $room)
                        @if(count($room['users']) > 0 && $room['type'] != 'role')
                        <option value="{{$rid}}" {{$rid == $eroom? 'selected="selected"':''}}>{{$room['name']}}</option>
                        @endif
                        @endforeach
                    </optgroup>
                    <optgroup label="Teams">
                        @foreach($rooms as $rid => $room)
                        @if($room['type'] == 'role')
                        <option value="{{$rid}}"  {{$rid == $eroom? 'selected="selected"':''}}>{{$room['name']}}</option>
                        @endif
                        @endforeach
                    </optgroup>
                </select>
                <br>
                <div class="chat-conversation">
                    <ul id="room-conversation" class="conversation-list">
                        
                    </ul>    
                </div>
                <form id="chat-box" class="mt-auto py-3">
                    <div class="row">
                        <div class="col-sm-9 pr-0">
                            <input type="text" class="form-control chat-input" placeholder="Enter your text">
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary chat-send btn-block waves-effect waves-light px-1">Send </button>
                        </div>
                    </div>
                </form>
            </div> <!-- end .p-3-->
        </div>
    </div>
    <div class="clear"></div>
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>