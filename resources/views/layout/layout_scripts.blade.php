<!-- Vendor js -->
<script src="../assets/js/vendor.min.js"></script>

<!-- App js -->
<!-- <script src="../assets/js/app.min.js"></script> -->
<script src="../assets/js/app.js"></script>

<!-- Parsleyjs -->
<script src="../assets/libs/parsleyjs/parsley.min.js"></script>

<!-- start -->
<!-- <script src = "https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script> -->
<script src="../assets/js/select2.min.js"></script>
 <!-- Jquery Ui js -->
<script src="../assets/libs/jquery-toast/jquery-ui-drop.min.js"></script>
<script src="../assets/libs/jquery-toast/drag-and-drop.js"></script>
<script src="../assets/libs/jquery-toast/form-summernote.init.js"></script>
<script src="../assets/libs/jquery-toast/summernote-bs4.min.js"></script>
<script src="../assets/libs/jquery-toast/bootstrap-tagsinput.min.js"></script>
<script src="../assets/libs/jquery-toast/bootstrap-select.min.js"></script>
<script src="../assets/libs/jquery-toast/jquery.toast.min.js"></script>
<script src="../assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
<script src="../assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Chacklist js -->
<script type="text/javascript">
// function to bind taskchecklist on edit task card

function taskchecklistfunction(id) {
    $.ajax({
        method:"POST",
        url:"{{route('taskmanagement.taskmanagement.taskchecklist')}}",
        headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
        data :{'taskid':id},
        success:function(data)
        {
                $("#progressbartask").width(data.progressbar+'%');
                $("#progressbartask").text(data.progressbar+'%');
                var chklistdata = data.data;
                var taskchklist = "";
                $.each(chklistdata, function(key, value){
                        var chck = chklistdata[key].completed;
                        taskchklist+='<span class="todo-wrap"><input type="checkbox" class="tchecklist" onclick="changechklist('+chklistdata[key].taskChecklistId+')" name="checkbox" id="chkbx'+chklistdata[key].taskChecklistId+'" value="'+chklistdata[key].checkListItemName  +'" '+chklistdata[key].complete+'  style="display:none" /><label for="chkbx'+chklistdata[key].taskChecklistId+'" class="todo"> <i class="fa fa-check"></i>'+chklistdata[key].checkListItemName+'</label><span class="delete-item" title="remove"><a onclick="deletechecklist('+chklistdata[key].taskChecklistId+')"><i class="fa fa-times-circle"></i></a></span></span>';
                });
                $("#taskchecklist-edit").html(taskchklist);
       }

    });
}
    $(document).ready(function(){
            // add items
        $('#add-todo').click(function(){
            var lastSibling = $('#todo-list > .todo-wrap:last-of-type > input').attr('id');
            var newId = Number(lastSibling) + 1;

            $(this).before('<span class="editing todo-wrap"><input type="checkbox" id="'+newId+'"  style="display: none;"/><label for="'+newId+'" class="todo" style=""><i class="fa fa-check"></i><input type="text" size="90%" class="input-todo" id="input-todo'+newId+'" /></label></div>');
            $('#input-todo'+newId+'').parent().parent().animate({
                height:"45px"
            },200)
            $('#input-todo'+newId+'').focus();


            $('#input-todo'+newId+'').enterKey(function(){
                var taskchecklist = $('#input-todo'+newId+'').val();

            $(this).trigger('enterEvent');
        });

        $('#input-todo'+newId+'').on('blur enterEvent',function(){
            var todoTitle = $('#input-todo'+newId+'').val();
            var todoTitleLength = todoTitle.length;
            if (todoTitleLength > 0) {
            $(this).before(todoTitle);
            $(this).parent().parent().removeClass('editing');
            $(this).parent().after('<span class="delete-item" title="remove"><i class="fa fa-times-circle"></i></span>');
            $(this).remove();
            $('.delete-item').click(function(){
                var parentItem = $(this).parent();
                parentItem.animate({
                left:"-30%",
                height:0,
                opacity:0
                },200);
                setTimeout(function(){ $(parentItem).remove(); }, 1000);
            });
            }
            else {
            $('.editing').animate({
                height:'0px'
            },200);
            setTimeout(function(){
                $('.editing').remove()
            },400)
            }
        })

        });
        $('body').on('click', '#saveCheckList', function () {
               var taskchecklist =$('#checklistComment').val();
                var taskid = $("#taskidedit").val();
                var completed = false;
                $.ajax({
                    method:"POST",
                    url:"{{route('api.taskchecklist.add')}}",
                    headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data :{'taskId':taskid,'completed':completed,'checkListItemName':taskchecklist},
                    success:function(data){
                        taskchecklistfunction(taskid);
                    }

                });
            });
        $('#edit-todo').click(function(){
            var lastSibling = $('#todo-list > .todo-wrap:last-of-type > input').attr('id');
            var newId = Number(lastSibling) + 1;
            var checklistComment=$('#checklistComment').val();
          if(checklistComment !='' && $('#saveCheckList').val()==undefined){
                $("#taskchecklist-edit").append('<span class="todo-wrap"><input type="checkbox" class="tchecklist" name="checkbox" id="'+newId+'" name="checkbox" style="display:none" /><label for="'+newId+'" class="todo"><i class="fa fa-check"></i><input type="text" class="input-todo" id="checklistComment"/></label><a style="background-color:#1abc9c" class="btn btn-light btn-sm font-13" id="saveCheckList"> Add</a></div>');
             }else{
                $.toast({
                        heading: 'Error',
                        text: 'Firstly fill the empty checklist value',
                        showHideTransition: 'slide',
                        position: 'top-right',
                        hideAfter: 1500,
                        bgColor: '#ff3d56',
                        icon: 'error'
                    });
            }

            // $('#input-todo'+newId+'').parent().parent().animate({
            //     height:"50px"
            // },200)
            $('#checklistComment').focus();
            $('#checklistComment').enterKey(function(){
                var taskchecklist = $('#checklistComment').val();
                var taskid = $("#taskidedit").val();
                var completed = false;
                $.ajax({
                    method:"POST",
                    url:"{{route('api.taskchecklist.add')}}",
                    headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data :{'taskId':taskid,'completed':completed,'checkListItemName':taskchecklist},
                    success:function(data){
                        taskchecklistfunction(taskid);
                    }

                });

            $(this).trigger('enterEvent');
        });

        $('#input-todo'+newId+'').on('blur enterEvent',function(){
            var todoTitle = $('#input-todo'+newId+'').val();
            var todoTitleLength = todoTitle.length;
            if (todoTitleLength > 0) {
            $(this).before(todoTitle);
            $(this).parent().parent().removeClass('editing');
            $(this).parent().after('<span class="delete-item" title="remove"><i class="fa fa-times-circle"></i></span>');
            $(this).remove();
            $('.delete-item').click(function(){
                var parentItem = $(this).parent();
                parentItem.animate({
                left:"-30%",
                height:0,
                opacity:0
                },200);
                setTimeout(function(){ $(parentItem).remove(); }, 1000);
            });
            }
            else {
            $('.editing').animate({
                height:'0px'
            },200);
            setTimeout(function(){
                $('.editing').remove()
            },400)
            }
        })

        });

        // remove items

        $('.delete-item').click(function(){
        var parentItem = $(this).parent();
        parentItem.animate({
            left:"-30%",
            height:0,
            opacity:0
        },200);
        setTimeout(function(){ $(parentItem).remove(); }, 1000);
        });

        // Enter Key detect

        $.fn.enterKey = function (fnc) {
            return this.each(function () {
                $(this).keypress(function (ev) {
                    var keycode = (ev.keyCode ? ev.keyCode : ev.which);
                    if (keycode == '13') {
                        fnc.call(this, ev);
                    }
                })
            })
        }

        // Select task tag
        $(".js-example-basic-multiple-limit-tagnew").select2({
            // tags:true
        });
        $(".js-example-basic-multiple-limit").select2({
            tags:true
        });

        $(".search-dropdown").select2({
        })
    });


</script>
<!-- End Chacklist js -->
<script>
    $(document).ready(function(){
       // $.fn.datepicker.defaults.format = 'mm/dd/yyyy';
        $('.datepicker').on('changeDate', function(e){
            $(this).datepicker('hide');
        });

        $('[data-toggle="input-mask"]').each(function (idx, obj) {
            var maskFormat = $(obj).data("maskFormat");
            var reverse = $(obj).data("reverse");
            if (reverse != null)
                $(obj).mask(maskFormat, {'reverse': reverse});
            else
                $(obj).mask(maskFormat);
        });
    });
</script>
<script>
$(document).ready(function() {
    $('.note-editing-area').find('textarea').attr('name','taskDetails');
   // On Submit Button Script
   $('#savetask').click(function(){
        var $form = $('#taskForm');
        var taskName = $("#taskName").val();
        var taskDetails= $('.note-editable').text();
        @if(Route::currentRouteName() != "web.taskproject.kanbanboard")
        var taskProjectId = $("#taskProjectId").val();
        @else
        var taskProjectId = {{Request::route('id')}};
        @endif
        var taskBoardId = $("#taskBoardId").val();
        var importance = $("#importance").val();
        var status = $("#addstatus").val();
        var taskStatusId = $("#taskStatusId").val();
        var startDate = $("#startDate").val();
        var dateComplete = $("#dateComplete").val();
        var dueDate = $("#dueDate").val();
        var taskTag = $("#taskTag").val();
        var user_id = $("#userId").val();
        var lead_id = $("#addleadid").val();
        var taskNote = $("#taskNote").val();
        var validate =  $form.parsley().validate();
        var checklist = [];
        $(".todo").each(function(i){
            checklist[i] = $(this).text();
        });
        var uid = "{{Auth::id()}}";
        var checklistData = checklist;
        console.log('tag', taskTag);
        if($.trim(taskDetails) == ''){
            if($("#parsley-id-n").length == 0){
                $('.note-editing-area').append('<ul class="parsley-errors-list filled" id="parsley-id-n"><li class="parsley-required">This value is required.</li></ul>');
                return false;
            }else{
                return false;
            }
        }
        if(validate){
            $("#savetask").attr("disabled", true);
            $('#parsley-id-n').remove();
            // Post
            $.ajax({
                url: "{{ route('taskmanagement.taskmanagement.add') }}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                method:"POST",
                data:{
                    taskName:taskName,
                    taskDetails:taskDetails,
                    taskProjectId:taskProjectId,
                    taskBoardId:taskBoardId,
                    importance:importance,
                    status:status,
                    taskStatusId:taskStatusId,
                    startDate:startDate,
                    dateComplete:dateComplete,
                    dueDate:dueDate,
                    createdBy:1,
                    taskTag:taskTag,
                    user_id:user_id,
                    leadid:lead_id,
                    taskNote:taskNote,
                    uid:uid,
                    checklistData:checklistData,
                },
                //dataType:'JSON',
                //contentType: false,
                //cache: false,
                //processData: true,
                success: function (data) {
                    if(data.message == 'Success'){
                        $.toast({
                            heading: 'Success',
                            text: 'Record Saved',
                            showHideTransition: 'slide',
                            position: 'top-right',
                            hideAfter: 1500,
                            bgColor: '#37cde6',
                            icon: 'info',
                            afterHidden: function () {
                                @if(Route::currentRouteName() == "web.taskproject.kanbanboard" || Route::currentRouteName() == "home")
                                window.location.reload();
                                @else
                                window.location.href="{{ route('web.taskmanagementlist.tasklist') }}";
                                @endif
                            }
                        });
                    } else {
                        console.log('result', data);
                    }
                },
                error: function (jqXHR, status) {
                    $("#savetask").attr("disabled", false);
                    $.toast({
                        heading: 'Error',
                        text: 'Record Add Failed',
                        showHideTransition: 'slide',
                        position: 'top-right',
                        hideAfter: 1500,
                        bgColor: '#ff3d56',
                        icon: 'error'
                    });
                }
            });
        }
    });

});
</script>
<script>
    $(document).ready(function(){

        @if(Route::currentRouteName() == "web.taskproject.kanbanboard")
        var projectId = {{Request::route('id')}};
        $.ajax({
                method:"POST",
                url:"{{ route('taskboardmanagement.taskboardmanagement.getboardlist')}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:{projectId:projectId},
                dataType:"JSON",
                success:function(response)
                {
                    var result = '<option value="" selected>Choose...</option>';

                    $.each(response, function(key,value){

                        result+='<option value="'+value.taskBoardId+'">'+value.boardName+'</option>';
                    });
                    $("#taskBoardId").html(result);
                    $("#edittaskBoardId").html(result);
                    $("#taskBoardId").selectpicker('refresh');
                    $("#edittaskBoardId").selectpicker('refresh');
                }
            });

        @else

        $("#taskProjectId").on('change',function(){
            var projectId = $("#taskProjectId").val();
            $.ajax({
                method:"POST",
                url:"{{ route('taskboardmanagement.taskboardmanagement.getboardlist')}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:{projectId:projectId},
                dataType:"JSON",
                success:function(response)
                {
                    var result = '<option value="" selected>Choose...</option>';

                    $.each(response, function(key,value){

                        result+='<option value="'+value.taskBoardId+'">'+value.boardName+'</option>';
                    });
                    $("#taskBoardId").html(result);
                    $("#taskBoardId").selectpicker('refresh');
                }
            });
        });
        @endif

    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script>
var socket = io.connect('{{env("REDIS_CLIENT", "https://messaging.aabocrm.com:3000/packtchat")}}');
wireEvents(socket);

function wireEvents(socketio){

	var roles = [];
	@foreach($uroles as $urole)
    roles.push('{{str_replace(' ', '', $urole->name)}}');
    @endforeach
    socketio.emit('join', {tenant: tenant, id: '{{Auth::id()}}', name: '{{Auth::user()->name}}', email: '{{Auth::user()->email}}', avatar:'{{Auth::user()->avatar?Auth::user()->avatar:"../assets/images/users/person.jpg"}}', roles: roles}, function(res){
		// console.log('Join', res);
        if (res && res.length > 0) {
            $('#top-chat .noti-icon-badge').removeClass('d-none').text(res.length);
            $('#top-chat .inbox-widget').empty();
            $('.right-bar .unread-list').empty();
            res.forEach(function(chat){
                var container = $('<a/>').addClass('inbox-item d-block').attr('href', '/message/'+chat.room);
                var avatarcontainer = $('<div/>').addClass('inbox-item-img');
                var avatar = $('<img/>').addClass('rounded-circle').attr('src', chat.user.avatar);
                var status = $('<i/>').addClass('user-status '+chat.user.status);
                avatarcontainer.append(avatar);
                avatarcontainer.append(status);
                container.append(avatarcontainer);
                container.append($('<p/>').addClass('inbox-item-author').append($('<span/>').addClass('text-dark mr-1').text(chat.user.name)).append($('<span/>').addClass('badge badge-light-success').text(chat.user.tenant)).append($('<span/>').addClass('float-right text-muted font-13').text(chatTime(chat.id))));
                container.append($('<p/>').addClass('inbox-item-text').text(chat.message));
                $('#top-chat .inbox-widget').prepend(container);
                $('.right-bar .unread-list').prepend(container.clone());
            });
        }
	});

	socketio.on('AddRoom', function(room){
		console.log(room);
        $.toast({
			heading: room.name,
			text: 'added room '+room.id,
			showHideTransition: 'slide',
			position: 'top-right',
			hideAfter: 2500,
			bgColor: '#1abc9c',
			icon: 'info'
		});
		var container = $('<a/>').addClass('inbox-item').attr('href', '/message/'+room.id);
		var avatarcontainer = $('<div/>').addClass('inbox-item-img');
		var avatar = $('<img/>').addClass('rounded-circle').attr('src', '../assets/images/users/new.jpg');
		avatarcontainer.append(avatar);
		container.append(avatarcontainer);
		container.append($('<p/>').addClass('inbox-item-author').append($('<span/>').addClass('text-dark').text('You are invited.')));
		container.append($('<p/>').addClass('inbox-item-text').text('Click here to chat.'));
		$('#chat-history').append(container);
	});

	socketio.on('AddUser', function(user){
		console.log(user);
        $.toast({
			heading: user.name,
			text: 'added room user '+user.avatar,
			showHideTransition: 'slide',
			position: 'top-right',
			hideAfter: 2500,
			bgColor: '#1abc9c',
			icon: 'info'
		});
	});

	socketio.on('ExitRoom', function(data){
		console.log('ExitRoom', data);
		if (roomid != data.room) {
			$('#chat-history .inbox-item').each(function(){
				if ($(this).data('chat') == data.room) $(this).remove();
			});
		}

        $.toast({
			heading: data.by,
			text: 'removed room '+data.room,
			showHideTransition: 'slide',
			position: 'top-right',
			hideAfter: 2500,
			bgColor: '#1abc9c',
			icon: 'info',
			afterHidden: function () {
				window.location.href="{{route('web.messages.index') }}";
			}
		});
	});

	socketio.on('NameRoom', function(data){
		console.log('NameRoom', data);
		$('#chat-history .inbox-item').each(function(){
			if ($(this).data('chat') == data.room) {
				$(this).find('.inbox-item-author span').text(data.name);
			}
		});
		if (roomid == data.room)
			$('#room-title').text('Chat Room: '+data.name);
        $.toast({
			heading: 'Success',
			text: 'renamed room '+data.room,
			showHideTransition: 'slide',
			position: 'top-right',
			hideAfter: 2500,
			bgColor: '#1abc9c',
			icon: 'info'
		});
	});

	socketio.on('Status', function(data){
		// console.log('Status', data);
		$('.user-status').each(function(){
			if ($(this).data('user') == data.user) {
				$(this).removeClass('online');
				$(this).removeClass('offline');
				$(this).addClass(data.status);
			}
		});
	});

	socketio.on('AddChat', function(chat){
		console.log(chat);
		if (roomid == chat.room) {
			var container = $('<li/>').addClass('clearfix').attr('data-chat', chat.id);
			var chatavatar = $('<div/>').addClass('chat-avatar').append($('<img/>').attr('src', chat.user.avatar)).append($('<i/>').addClass('online user-status').attr('data-user', chat.user.tenant+':'+chat.user.id)).append($('<i/>').addClass('time').text(chatTime()));
			container.append(chatavatar);
			var chattext = $('<div/>').addClass('conversation-text');
			var textwrap = $('<div/>').addClass('ctext-wrap').append($('<i/>').text(chat.user.name).append('&nbsp;').append('&nbsp;').append($('<span/>').addClass('badge badge-light-success').text(tenant))).append($('<p/>').text(chat.message));
			chattext.append(textwrap);
			container.append(chattext);
			$('#room-conversation').append(container);
			$('#chat-history .bg-light .inbox-item-text').text(chat.user.name+': '+chat.message);
			$('#chat-history .inbox-item').each(function(){
				if ($(this).data('chat') == chat.room) {
					$(this).find('.inbox-item-text').text(chat.user.name+': '+chat.message);
				}
			});
		} else if (eroomid == chat.room) {
			var container = $('<li/>').addClass('clearfix').attr('data-chat', chat.id);
			var dt = new Date();
			var chatavatar = $('<div/>').addClass('chat-avatar').append($('<img/>').attr('src', chat.user.avatar)).append($('<i/>').addClass('online user-status').attr('data-user', chat.user.tenant+':'+chat.user.id)).append($('<i/>').addClass('time').text(chatTime()));
			container.append(chatavatar);
			var chattext = $('<div/>').addClass('conversation-text');
			var textwrap = $('<div/>').addClass('ctext-wrap').append($('<i/>').text(chat.user.name).append('&nbsp;').append('&nbsp;').append($('<span/>').addClass('badge badge-light-success').text(tenant))).append($('<p/>').text(chat.message));
			chattext.append(textwrap);
			container.append(chattext);
			$('#room-conversation').append(container);
            if ($('body').hasClass('right-bar-enabled') && $('.chat-tab').hasClass('active')) {
                socket.emit('ReadRoom', {room: eroomid, tenant: tenant, id: '{{Auth::id()}}'}, function(res){
                    console.log('ReadRoom Success', res);
                });
            } else {
                addUnreadUI(chat);
            }
		} else {
            addUnreadUI(chat);
		}

		$('#room-conversation').slimScroll({scrollBy: '10000px'});

        $.toast({
			heading: chat.user.name+' says',
			text: chat.message,
			showHideTransition: 'slide',
			position: 'top-right',
			hideAfter: 2500,
			bgColor: '#1abc9c',
			icon: 'info'
		});
	});

	socketio.on('AddNotification', function(chat){
		console.log(chat);
		if (notification_view) {
			var notiContainer = $('<a/>').addClass("dropdown-item notify-item").attr('href', 'javascript:;');
			var notiIcon = $('<div/>').addClass('notify-icon bg-soft-primary text-primary').append($('<i/>').addClass('mdi mdi-comment-account-outline'));
			var notiDetails = $('<p/>').addClass('notify-details').text(chat.user.name+' '+chat.message);
			notiDetails.append($('<small/>').addClass('text-muted').text(new Date(chat.ts).toLocaleString()));
			notiContainer.append(notiIcon);
			notiContainer.append(notiDetails);
			$('#noti-container').append(notiContainer);
		} else {
			if ($('#top-notification .noti-icon-badge').length == 0) {
				$('#top-notification .nav-link').append($('<span/>').addClass('badge badge-success rounded-circle noti-icon-badge').text('1'));
			} else {
				var old = parseInt($('#top-notification .noti-icon-badge').text());
				$('#top-notification .noti-icon-badge').text(old+1);
			}

			var notiContainer = $('<a/>').addClass("dropdown-item notify-item").attr('href', '{{route('web.notifications.index')}}');
			var notiIcon = $('<div/>').addClass('notify-icon bg-soft-primary text-primary').append($('<i/>').addClass('mdi mdi-comment-account-outline'));
			var notiDetails = $('<p/>').addClass('notify-details').text(chat.user.name+' '+chat.message);
			var notiChat = $('<p/>').addClass('text-muted mb-0 user-msg').append($('<small/>').text(new Date(chat.ts).toLocaleString()));
			notiContainer.append(notiIcon);
			notiContainer.append(notiDetails);
			notiContainer.append(notiChat);
			$('#top-notification .noti-scroll').prepend(notiContainer);
		}

        $.toast({
			heading: 'Got new notification!',
			text: chat.user.name+' '+chat.message,
			showHideTransition: 'slide',
			position: 'top-right',
			hideAfter: 2500,
			bgColor: '#1abc9c',
			icon: 'info'
		});
	});

	$("#selectRoom").select2();
	$("#selectRoom").on('select2:select', function(e){
		var data = e.params.data;
        if (data.id == "Select Room") return;
        console.log(data);
		getChat(data.id);
	});

    $(document).on('click', '.select2-results__group', function(e){
		e.preventDefault();
		$("#selectRoom").select2('close');
	});

	getChat('{{isset($roomid)?$roomid:$eroom}}');
};

function addUnreadUI(chat) {
    $('#top-chat .noti-icon-badge').removeClass('d-none');
    var old = parseInt($('#top-chat .noti-icon-badge').text());
    $('#top-chat .noti-icon-badge').text(old+1);

    console.log('old', old);
    var container = $('<a/>').addClass('inbox-item d-block').attr('href', '/message/'+chat.room);
    var avatarcontainer = $('<div/>').addClass('inbox-item-img');
    var avatar = $('<img/>').addClass('rounded-circle').attr('src', chat.user.avatar);
    var status = $('<i/>').addClass('user-status '+chat.user.status);
    avatarcontainer.append(avatar);
    avatarcontainer.append(status);
    container.append(avatarcontainer);
    container.append($('<p/>').addClass('inbox-item-author').append($('<span/>').addClass('text-dark mr-1').text(chat.user.name)).append($('<span/>').addClass('badge badge-light-success').text(chat.user.tenant)).append($('<span/>').addClass('float-right text-muted font-13').text(chatTime(chat.id))));
    container.append($('<p/>').addClass('inbox-item-text').text(chat.message));

    $('#top-chat .inbox-widget').prepend(container);
    $('.right-bar .unread-list').prepend(container.clone());
    $('#chat-history .inbox-item').each(function(){
        if ($(this).data('chat') == chat.room) {
            $(this).find('.inbox-item-text').text(chat.user.name+': '+chat.message);
            $(this).addClass('bg-light-warning');
        }
    });
}
function getChat(roomid) {
	eroomid = roomid;
	socket.emit('GetChat', roomid, function(res){
		console.log("GetChat", res);
		$('#room-conversation').empty();
		var old_datestr = '';
		res.forEach(function(chat){
			var odd = chat.user.id == '{{Auth::id()}}' && chat.user.tenant == tenant?'odd':'';
			var datestr = new Date(chat.id).toLocaleString('en-us',{month:'short', day:'numeric'});
			var container = $('<li/>').addClass('clearfix '+odd).attr('data-chat', chat.id);
			var chatavatar = $('<div/>').addClass('chat-avatar').append($('<img/>').attr('src', chat.user.avatar)).append($('<i/>').addClass('user-status '+chat.user.status).attr('data-user', chat.user.tenant+':'+chat.user.id)).append($('<i/>').addClass('time').text(chatTime(chat.id)));
			container.append(chatavatar);
			var chattext = $('<div/>').addClass('conversation-text');
			var i = null;
			if (odd) i = $('<i/>').text(chat.user.name);
			else i = $('<i/>').text(chat.user.name).append('&nbsp;').append('&nbsp;').append($('<span/>').addClass('badge badge-light-success').text(tenant));
			var textwrap = $('<div/>').addClass('ctext-wrap').append(i).append($('<p/>').text(chat.message));
			chattext.append(textwrap);
			container.append(chattext);
			if (old_datestr != datestr) {
				old_datestr = datestr;
				var today = new Date();
				var todaystr = today.toLocaleString('en-us',{month:'short', day:'numeric'});
				var yesterday = new Date(today.setDate(today.getDate() - 1));
				var yesterdaystr = yesterday.toLocaleString('en-us',{month:'short', day:'numeric'});
				if (datestr == todaystr)
					container.prepend($('<p/>').addClass('text-center').text("Today"));
				else if (datestr == yesterdaystr)
					container.prepend($('<p/>').addClass('text-center').text("Yesterday"));
				else
					container.prepend($('<p/>').addClass('text-center').text(datestr));

			}
			$('#room-conversation').append(container);
		});
		$('#room-conversation').slimScroll({scrollBy: '10000px'});
	});
}

$('#chat-box').submit(function(event){
    event.preventDefault();
	var inputval = $('.chat-input').val();
	if (!inputval) return;
	@if(isset($roomid))
	socket.emit('AddChat', {message:inputval , room: '{{$roomid}}', tenant: tenant, user: {{Auth::id()}}}, function(res) {
		console.log('AddChat : Chat Page', res);
		selfAddChat();
	});
	@else
	socket.emit('AddChat', {message:inputval , room: eroomid, tenant: tenant, user: {{Auth::id()}}}, function(res){
		console.log('AddChat : Right Bar', res);
		selfAddChat();
	});
	@endif
});
$('.inbox-widget').slimScroll({
    height: '100%'
});
$('#room-conversation').slimScroll({
	height: 'auto',
	start: 'bottom'
});
$('.right-bar.nav-pills a').on('shown.bs.tab', function(event){
    $('#room-conversation').slimScroll();
});
function chatTime(timestamp = null) {
	var dt = new Date();
	if (timestamp) dt = new Date(timestamp);
    var hour = parseInt(dt.getHours());
    var isPM = " AM";
    if (hour >= 12) {
        isPM = " PM";
        hour -= 12;
    }
	return ("0" + hour).slice(-2) + ":" + ("0" + dt.getMinutes()).slice(-2) + isPM;
}
function selfAddChat() {
	var container = $('<li/>').addClass('clearfix odd').attr('data-chat', Date.now());
    var chatavatar = $('<div/>').addClass('chat-avatar').append($('<img/>').attr('src', '{{Auth::user()->avatar?Auth::user()->avatar:"../assets/images/users/person.jpg"}}')).append($('<i/>').addClass('online user-status')).append($('<i/>').addClass('time').text(chatTime()));
    container.append(chatavatar);
    var chattext = $('<div/>').addClass('conversation-text');
    var textwrap = $('<div/>').addClass('ctext-wrap').append($('<i/>').text('{{Auth::user()->name}}')).append($('<p/>').text($('.chat-input').val()));
    chattext.append(textwrap);
    container.append(chattext);
    $('#room-conversation').append(container);
    $('#chat-box')[0].reset();
	$('#room-conversation').slimScroll({scrollBy: '100000px'});
}
function clearall() {
    socket.emit('ReadAll', {tenant: tenant, id: '{{Auth::id()}}'}, function(res){
        $('.unread-list').empty();
        $('#top-chat .noti-icon-badge').addClass('d-none').text(0);
    });
}

function clearall_notification() {
    socket.emit('ReadAll', {tenant: tenant, id: '{{Auth::id()}}'}, function(res){
        $('.unread-list').empty();
        $('#top-chat .noti-icon-badge').addClass('d-none').text(0);
    });
}


</script>

<!-- Start code to edit Task Card -->
<script>
$('#startDate').datepicker('setDate', 'today');

 function editTaskCard(taskid){
     $('#edittaskBoardId').val("").trigger('change');

     $.ajax({
            method:"POST",
            url:"{{route('taskmanagement.taskmanagement.taskcard')}}",
            headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
            data: {'taskId': taskid},
            success: function (data) {

                if(data.created_by.avatar) {
                    $("#createdby").html('<img src="'+data.created_by.avatar+'" alt="task-user" class="avatar-sm img-thumbnail rounded-circle">'+data.created_by.name);
                }   else {
                    $("#createdby").html('<img src="../images/users/default-user.png" alt="task-user" class="avatar-sm img-thumbnail rounded-circle">'+data.created_by.name);
                }

                var res = data.users;
                var user = [];
                $.each(res, function(key, value){
                    user.push(res[key].id);
                });
                var tagres = data.tasktag;

                var opt =[];
                $.each(tagres, function(key, value){
                    opt.push(tagres[key].taskTag);
                });
                // $.each(tagres, function(key, value){
                //     opt+='<option value = "'+tagres[key].taskTag+'" selected = "selected">'+tagres[key].taskTag+'</option>';
                // });
                $("#edittaskName").val(data.taskName);
                $("#summernote-editor-edit").summernote("code", data.taskDetails);
                $("#editstartDate").val(data.startDate);
                $("#editdueDate").val(data.dueDate);
                $("#editcompletedDate").val(data.dateCompleted);
                $("#edittaskProjectId").val(data.taskProjectId).trigger('change');
                bindproject(data.taskBoardId);
                $('#editstatus').val(data.status).trigger('change');
                $('#editimportance').val(data.importance).trigger('change');
                $('#edittaskStatusId').val(data.taskStatusId).trigger('change');
                $("#edituserId").val(user).trigger('change');
                $("#editleadid").val(data.leadid).trigger('change');
                //$("#edittaskTag").val(data.tasktag[0].taskTagId).trigger('change');
                $('#edittaskTag').val(opt).trigger('change');
                $("#edittaskTag").selectpicker('refresh');
                $("#taskidedit").val(data.taskId);
                $('#edit_task').modal('show');
                tasknotes(data.taskId);
                taskchecklistfunction(data.taskId);
                taskwatched(data.taskId);
            }

     });
 }

 function tasknotes(id)
 {
    $.ajax({
        method:"POST",
        url:"{{route('taskmanagement.taskmanagement.tasknotes')}}",
        headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
        data :{'taskid':id},
        success:function(data)
        {
            var tasknote = data;
                var tasksnote = "";
                $.each(tasknote, function(key, value){
                    var createdAt = tasknote[key].created_at11;
                    var tasknoteid = $.trim(tasknote[key].tasknoteid);
                    tasksnote+='<div class="media mb-4 mt-1">';
                    if(tasknote[key].users.avatar){
                        tasksnote+='<img class="d-flex mr-2 rounded-circle avatar-sm" src="'+tasknote[key].users.avatar+'" alt="Generic placeholder image">';
                    } else {
                        tasksnote+='<img class="d-flex mr-2 rounded-circle avatar-sm" src="../images/users/default-user.png" alt="Generic placeholder image">';
                    }

                    tasksnote+='<div class="media-body">';
                    tasksnote+='<h6 class="m-0 font-14">'+tasknote[key].users.name+'<span class="ml-3 text-muted">'+createdAt+'</span></h6>';
                    tasksnote+='<p class="mt-2" id="mycommentedit_'+tasknoteid+'">'+tasknote[key].note+'</p>';
                    tasksnote+='<div class="btn-group mr-5">';
                    tasksnote+='<button type="button" class="btn btn-comment-color waves-effect text-left" id="edit_'+tasknoteid+'" onclick="editComment('+tasknoteid+')">Edit</button>';
                    tasksnote+='<button type="button" class="btn btn-comment-color waves-effect" onclick="deleteComment('+tasknoteid+')">Delete</button></div></div></div>';
                });
                @if(Auth::user()->avatar)
                    tasksnote+='<img class="d-flex mr-2 rounded-circle avatar-sm" src="{{ (Auth::user()->avatar)}}" alt="Generic placeholder image"><div class="media-body"><input type="text" id="edittaskNote" name="taskNote" class="form-control" placeholder="Add a comment...."><a style="cursor:pointer" class="btn btn-success" id="addnewcomment" onclick="submitcomment()" name="add">Save</a></div>';
                @else
                    tasksnote+='<div class="media-body d-flex"><img class="mr-2 rounded-circle avatar-sm" src="../images/users/default-user.png" alt="Generic placeholder image"><input type="text" id="edittaskNote" name="taskNote" class="form-control" placeholder="Add a comment...."><a style="cursor:pointer" class="btn btn-success" id="addnewcomment" onclick="submitcomment()" name="add">Save</a></div>';
                @endif

                $("#edittasknotev").html(tasksnote);

                //$().scrollTop($(document).height());
                $(document).scrollTop($(document).offset().bottom);

        }

    });
 }

// start edit task note on edit task card
function submitcomment()
{
     var note = $("#edittaskNote").val();
     var newone=note.trim();
     if(newone.length ==0) {
        $.toast({
                heading: 'Error',
                text: 'Please Add Comment',
                showHideTransition: 'slide',
                position: 'top-right',
                hideAfter: 1500,
                bgColor: '#f06b78',
                icon: 'info',
                afterHidden: function () {
                    //taskchecklistfunction(taskid);
                    //window.location.href="{{ url('tasktag') }}";
                }
            });
     } else {
        var taskid = $("#taskidedit").val();
        var urid = "{{Auth::id()}}";
        $.ajax({
            type: "POST",
            url: "{{route('tasknotemanagement.tasknotemanagement.add')}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
            data: { note:note, taskid:taskid,userid:urid},
            success: function(data){
                tasknotes(taskid);
                $('#edittasknotev').animate({scrollBottom: 0});
            }
        });
    }
}

function editComment(id) {

    if($("#edit_"+id).text() == "Save") {
        var text = $("#mycommentedit_"+id).text();
        $.ajax({
            type: "POST",
            url: "{{route('taskmanagement.taskmanagement.edittasknote')}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
            data: { text:text, id:id},
            success: function(data){
                $("#mycommentedit_"+id).prop('contenteditable', false );
                $("#edit_"+id).text('Edit');
            }
        });
    } else {
        $("#edit_"+id).text('Save');
        $("#mycommentedit_"+id).attr('contenteditable','true').focus();
    }

}
// end edit task note on edit task card

// start function to delete task note

function deleteComment(id) {
    $.ajax({
            type: "POST",
            url: "{{route('taskmanagement.taskmanagement.deletetasknote')}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
            data: {id:id},
            success: function(data){
                $("#mycommentedit_"+id).parent().parent().remove();
            }
        });

}
// end function to delete task note





// function to delete taskchecklist on
function deletechecklist(id){
    var taskid = $("#taskidedit").val();
    $.ajax({
        method:"POST",
        url:"{{route('api.taskchecklist.delete')}}",
        headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
        data :{'checklistid':id},
        success:function(data)
        {
            $("#chkbx"+id).parent().remove();
            taskchecklistfunction(taskid);
        }

    });
}

// checked or unchecked task checklist
        function changechklist(id){
            var taskid = $("#taskidedit").val();
            if($("#chkbx"+id).prop("checked") == true){
                $.ajax({
                    url:"{{route('api.taskchecklist.changecompleted')}}",
                    method:"POST",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data :{'checklistid':id,'changeable':true},
                    success:function(data){
                        $.toast({
                            heading: 'Success',
                            text: 'Record Update',
                            showHideTransition: 'slide',
                            position: 'top-right',
                            hideAfter: 1500,
                            bgColor: '#37cde6',
                            icon: 'info',
                            afterHidden: function () {
                                taskchecklistfunction(taskid);
                                //window.location.href="{{ url('tasktag') }}";
                            }
                        });
                    },
                    error: function (jqXHR, status) {
                        $.toast({
                            heading: 'Error',
                            text: 'Record Update Failed',
                            showHideTransition: 'slide',
                            position: 'top-right',
                            hideAfter: 1500,
                            bgColor: '#ff3d56',
                            icon: 'error'
                        });
                    }

                });
            }
            else if($("#chkbx"+id).prop("checked") == false){
                $.ajax({
                    url:"{{route('api.taskchecklist.changecompleted')}}",
                    method:"POST",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data :{'checklistid':id,'changeable':false},
                    success:function(data){
                        $.toast({
                            heading: 'Success',
                            text: 'Record Update',
                            showHideTransition: 'slide',
                            position: 'top-right',
                            hideAfter: 1500,
                            bgColor: '#37cde6',
                            icon: 'info',
                            afterHidden: function () {
                                taskchecklistfunction(taskid);
                            }
                        });
                    },
                    error: function (jqXHR, status) {
                        $.toast({
                            heading: 'Error',
                            text: 'Record Update Failed',
                            showHideTransition: 'slide',
                            position: 'top-right',
                            hideAfter: 1500,
                            bgColor: '#ff3d56',
                            icon: 'error'
                        });
                    }

                });

            }

        }


</script>

<script>
    function taskwatched(id)
    {
        $.ajax({
            method:"POST",
            url:"{{route('api.taskwatched.taskwatchedcount')}}",
            headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
            data :{'taskid':id},
            success:function(data)
            {
                $("#totalcount").text(data.datacount);
                if(data.active==1){
                    $("span.fa.fa-eye").addClass("active");
                }else{
                    $("span.fa.fa-eye").removeClass("active");
                }

            }


        })
    }

$(document).ready(function() {
    $('#editwatched').click(function(){
        var taskid = $("#taskidedit").val();
        var uid = "{{Auth::id()}}";
        $.ajax({
                method:"POST",
                url:"{{ route('api.taskwatched.add') }}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:{taskId:taskid,userId:uid},
                success:function(data)
                {
                    $("#totalcount").text(data.datacount);
                    if(data.active==1){
                    $("span.fa.fa-eye").addClass("active");
                }else{
                    $("span.fa.fa-eye").removeClass("active");
                }

                    $.toast({
                        heading: 'Success',
                        text: data.message,
                        showHideTransition: 'slide',
                        position: 'top-right',
                        hideAfter: 1500,
                        bgColor: '#37cde6',
                        icon: 'info',
                        afterHidden: function () {
                            //window.location.href="{{ url('tasktag') }}";
                        }
                    });
                },
                error: function (jqXHR, status) {
                    $.toast({
                        heading: 'Error',
                        text: 'Record Add Failed',
                        showHideTransition: 'slide',
                        position: 'top-right',
                        hideAfter: 1500,
                        bgColor: '#ff3d56',
                        icon: 'error'
                    });
                }
        })
    });
});
</script>

<script>
$(document).ready(function() {
   // On Submit Button Script
   $('#editsavetask').click(function(){
        var $form = $('#edittaskForm');
        var taskName = $("#edittaskName").val();
        var taskDetails= $('.note-editable').text();
        @if(Route::currentRouteName() != "web.taskproject.kanbanboard")
        var taskProjectId = $("#edittaskProjectId").val();
        @else
        var taskProjectId = {{Request::route('id')}};
        @endif
        var taskBoardId = $("#edittaskBoardId").val();
        var importance = $("#editimportance").val();
        var status = $("#editstatus").val();
        var taskStatusId = $("#edittaskStatusId").val();
        var startDate = $("#editstartDate").val();
        var dateComplete = $("#editdateComplete").val();
        var dueDate = $("#editdueDate").val();
        var taskTag = $("#edittaskTag").val();
        var user_id = $("#edituserId").val();
        var lead_id = $("#editleadid").val();
        var taskNote = $("#edittaskNote").val();
        var validate =  $form.parsley().validate();
        var taskid = $("#taskidedit").val();
        var checklist = [];
        $(".todo").each(function(i){
            checklist[i] = $(this).text();
        });
        var uid = "{{Auth::id()}}";
        var checklistData = checklist;
        if($.trim(taskDetails) == ''){
            if($("#parsley-id-n").length == 0){
                $('.note-editing-area').append('<ul class="parsley-errors-list filled" id="parsley-id-n"><li class="parsley-required">This value is required.</li></ul>');
                return false;
            }
        }

        if(validate){
            $('#parsley-id-n').remove();
            // Post
            var url = "{{ route('taskmanagement.taskmanagement.update',':id') }}";
            url = url.replace(':id',taskid);
            $.ajax({
                url: url,
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                method:"PUT",
                data:{
                    taskName:taskName,
                    taskDetails:taskDetails,
                    taskProjectId:taskProjectId,
                    taskBoardId:taskBoardId,
                    importance:importance,
                    status:status,
                    taskStatusId:taskStatusId,
                    startDate:startDate,
                    dateComplete:dateComplete,
                    dueDate:dueDate,
                    createdBy:1,
                    taskTag:taskTag,
                    user_id:user_id,
                    leadid:lead_id,
                    taskNote:taskNote,
                    uid:uid,
                    checklistData:checklistData,
                },
                success: function (data) {
                    $.toast({
                        heading: 'Success',
                        text: 'Record Saved',
                        showHideTransition: 'slide',
                        position: 'top-right',
                        hideAfter: 1500,
                        bgColor: '#37cde6',
                        icon: 'info',
                        afterHidden: function () {
                           $('#edit_task').modal('hide');
                           window.location.href="{{ route('web.taskmanagementlist.tasklist') }}";
                        }
                    });
                },
                error: function (jqXHR, status) {
                    $.toast({
                        heading: 'Error',
                        text: 'Record Add Failed',
                        showHideTransition: 'slide',
                        position: 'top-right',
                        hideAfter: 1500,
                        bgColor: '#ff3d56',
                        icon: 'error'
                    });
                }
            });
        }
    });

});
</script>

<!-- change left dropdown box -->
<script>
$(document).ready(function() {

    $("#edittaskProjectId").selectpicker('refresh');
    $("#edittaskProjectId").on('change',function(){
        bindproject();
    });

   $('#toggleBtn').click(function(){
        $.ajax({
                url: "{{route("web.leftpannel.change")}}",
                method:"GET",
                success: function (data) {

            },
            error: function (jqXHR, status) {

            }
        });
    });
});


function bindproject(id=0) {

var projectId = $("#edittaskProjectId").val();
            $.ajax({
                method:"POST",
                url:"{{ route('taskboardmanagement.taskboardmanagement.getboardlist')}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:{projectId:projectId},
                dataType:"JSON",
                success:function(response)
                {
                    var result = '<option value="" selected>Choose...</option>';

                    $.each(response, function(key,value){

                        result+='<option value="'+value.taskBoardId+'">'+value.boardName+'</option>';
                    });
                    $("#edittaskBoardId").html(result);
                    $("#edittaskBoardId").selectpicker('refresh');
                    if(id) {
                        setTimeout(() => {
                            $('#edittaskBoardId').val(id).trigger('change');
                        }, 100);

                    }
                }
            });
        }

setTimeout(() => {
    if({{Cache::get('leftpannel')??0}}) {
      //  $("body").attr("class", "left-side-menu-dark sidebar-enable enlarged");
    } else {
       //  $("body").attr("class", "left-side-menu-dark");
        }
},1);

function ClearEditTaskData(id)
{
    window.location.href="{{ route('web.taskmanagementlist.tasklist') }}";
}
</script>
