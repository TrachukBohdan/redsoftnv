@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Chat</div>

                    <div class="panel-body">

                        <div id="chat">

                        </div>

                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                        <input type="hidden" name="post_action" value="{{url('send-msg')}}" />
                        <input type="hidden" name="pull_action" value="{{url('all-msg')}}" />

                        <textarea id="msg-text" class="form-control"></textarea>
                        <br />
                        <input id="send-msg" class="btn btn-primary" type="button" value="send message">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        jQuery(document).ready(function($){

            var pullAction = $("input[name='pull_action']").val();

            $.ajax({
                type: "GET",
                url: pullAction,
                dataType: "json",
                success:function(data){
                    for(var msg in data)
                    {
                        renderMsg(data[msg])
                    }
                }
            });

            $('#send-msg').click(function(e){

                var userId = $("input[name='user_id']").val();
                var msgText = $('#msg-text').val();
                var postAction = $("input[name='post_action']").val();

                if(msgText != '')
                {
                    $.ajax({
                        type: "POST",
                        url: postAction,
                        dataType: "json",
                        data: {
                            '_token':window.Laravel.csrfToken,
                            'message':msgText,
                            'user_id':userId
                        },
                        success:function(data){
                            console.log(data);
                        }
                    });
                }
            })

        });

        var socket = io.connect('http://localhost:8890');

        socket.on('message', function (data) {
            data = jQuery.parseJSON(data);
            renderMsg(data);
        });

        function renderMsg(data)
        {
            $( "#chat" ).append( `
                <div class="message">
                    <b class="username" >${data.email}</b>
                    <span class="text" >${data.message}</span>
                </div>
                <hr />
            ` );
        }
    </script>
@endsection
