<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel='stylesheet' href='{{asset("vendor/crudbooster/assets/css/chat.css")}}'/>
    <link rel='stylesheet' href='{{asset("vendor/crudbooster/assets/css/custom-style-rtl.css")}}'/>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body style="background: #faf5e1;">

<div class="container" style="width: 80%">
    <div class="col-md-12">

        <div class="col-md-12 col-sm-12 col-xs-12 right-sidebar">
            <div class="row">
                <div class="col-md-12 right-header">
                    <center>
                        <h1 style="color: white">تفاصيل المحادثة</h1>
                    </center>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 right-header-contentChat">
                    <ul>
                        @foreach($conversation as $item)
                            @if($item->from_user_id == $item->from_id)
                                <li>
                                    <div class="rightside-left-chat ">
                                        <span><i class="fa fa-circle" aria-hidden="true"></i> <?= DB::table('application_users')->where('id',$item->from_id)->first()->username ?></span><br><br>
                                        <p>{{$item->message}}</p>
                                    </div>
                                </li>
                            @else
                                <li>
                                    <div class="rightside-right-chat">
                                        <span><?= DB::table('application_users')->where('id',$item->from_id)->first()->username ?> <i class="fa fa-circle" aria-hidden="true"></i></span><br><br>
                                        <p style="text-align: right">{{$item->message}}</p>
                                    </div>
                                </li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function(){
        var height = $(window).height();
        $('.left-chat').css('height', (height - 92) + 'px');
        $('.right-header-contentChat').css('height', (height - 163) + 'px');
    });
</script>
</body>
</html>