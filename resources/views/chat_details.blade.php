<!DOCTYPE html>
<html>
<head>
    <title>تفاصيل المحادثة</title>
    <style>
        body, html {
            font-family: tahoma;
            line-height: 30px;
            padding: 0px;
            margin: 0px;
        }

        .header {
            font-size: 26px;
            margin: 0 auto;
            text-align: center;
            color: #9F6905;
            font-weight: lighter;
            background-color: #f0f0f0;
            height: 50px;
            line-height: 50px;
            border-bottom: 1px solid #9F6905;
        }

        .container {
            width: 450px;
            cursor: default;
            margin: 20px auto;
            height: 100%;
            overflow-y: scroll;
        }

        .container::-webkit-scrollbar {
            width: 3px;
            max-width: 3px;
            height: auto;
            max-height: 8px;
        }

        .container::-webkit-scrollbar-thumb {
            background: #f0f0f0;
            border-radius: 5px;
            max-width: 3px;
        }

        .container::-webkit-scrollbar-track {
            background: #9F6905;
            border-radius: 5px;
        }

        .Area {
            margin: 0 auto;
            width: 400px;
            background-color: rgba(240, 240, 240, 0.2);
            display: table;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .L {
            float: left;
        }

        img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #f0f0ff;
            padding: 5px;
        }

        img:hover {
            -moz-box-shadow: 0 5px 5px rgba(223, 120, 8, 1);
            -webkit-box-shadow: 0 5px 5px rgba(223, 120, 8, 1);
            box-shadow: 0 5px 5px rgba(223, 120, 8, 1);
            -webkit-transition: all 1.5s;
            -moz-transition: all 1.5s;
            transition: all 1.5s;
            cursor: pointer;
        }

        .R {
            float: right;
        }

        .text {
            color: #a4a4a4;
            font-family: tahoma;
            font-size: 13px;
            font-weight: lighter;
            line-height: 30px;
            width: 300px;
            border: 1px solid #f0f0f0;
            background-color: rgba(255, 255, 255, 0.6);
            margin-top: 10px;
            border-radius: 5px;
            padding: 5px;
        }

        .Area textarea {
            font-size: 12px;
            width: 90%;
            max-width: 90%;
            min-width: 90%;
            padding: 5%;
            border-radius: 5px;
            border: 1px solid #f0f0f1;
            max-height: 50px;
            height: 50px;
            min-height: 50px;
            background-color: #333;
            color: #fff;
            outline: none;
            border: 1px solid transparent;
            resize: none;
        }

        .Area textarea:focus {
            color: #333;
            border: 1px solid #ccc;
            -webkit-transition: all 1.5s;
            -moz-transition: all 1.5s;
            transition: all 1.5s;
            background-color: #fff;
        }

        .Area .note {
            color: #9F6905;
            font-size: 10px;
        }

        .R .tooltip {
            font-size: 10px;
            position: absolute;
            background-color: #fff;
            padding: 5px;
            border-radius: 5px;
            border: 2px solid #9F6905;
            margin-left: 70px;
            margin-top: -70px;
            display: none;
            color: #545454;
        }

        .R .tooltip:before {
            content: '';
            position: absolute;
            width: 1px;
            height: 1px;
            border: 5px solid transparent;
            border-right-color: #9F6905;
            margin-top: 10px;
            margin-left: -17px;
        }

        .R:hover .tooltip {
            display: block;
        }

        .L .tooltip {
            font-size: 10px;
            position: absolute;
            background-color: #fff;
            padding: 5px;
            border-radius: 5px;
            border: 2px solid #9F6905;
            margin-left: 70px;
            margin-top: -70px;
            display: none;
            color: #545454;
        }

        .L .tooltip:before {
            content: '';
            position: absolute;
            width: 1px;
            height: 1px;
            border: 5px solid transparent;
            border-right-color: #9F6905;
            margin-top: 10px;
            margin-left: -17px;
        }

        .L:hover .tooltip {
            display: block;
        }

        a {
            text-decoration: none;
        }

        .Area input[type=button] {
            font-size: 12px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #f0f0f1;
            background-color: #333;
            color: #fff;
            outline: none;
            border: 1px solid transparent;
            float: left;
        }

        .Area input[type=button]:hover {
            color: #fff;
            border: 1px solid #ccc;
            -webkit-transition: all 1.5s;
            -moz-transition: all 1.5s;
            transition: all 1.5s;
            background-color: #9F6905;
        }

        .validation {
            float: left;
            background-color: #ccc;
            border-radius: 5px;
            padding: 5px;
            font-size: 12px;
            line-height: 14px;
            height: 0px;
            margin-left: 5px;
            display: none;
        }

        br {
            clear: both;
            height: 20px;
        }
    </style>
</head>
<body>
<div class="header">تفاصيل المحادثة</div>

<div class="container">

    @foreach($conversation as $item)
        @if($item->from_user_id == $item->from_id)
            <div class="Area">
                <div class="L">
                    <a href="https://twitter.com/SamiMassadeh">
                        <img src="<?= url('/')."/".DB::table('application_users')->where('id',$item->from_id)->first()->image ?>"/>
                    </a>
                </div>
                <div class="text R textR">{{$item->message}}
                </div>
            </div>
        @else
            <div class="Area">
                <div class="R">
                    <a href="https://twitter.com/MariamMassadeh">
                        <img src="<?= url('/')."/".DB::table('application_users')->where('id',$item->from_id)->first()->image ?>"/>
                    </a>
                </div>
                <div class="text R textR">{{$item->message}}
                </div>
            </div>
        @endif
    @endforeach


</div>


<script>
    function clickX() {
        $(".validation").animate({'height': '16px'}, 500).show();
    }
</script>
</body>
</html>