    <html>
        <head>
            <style>
                body{
                    line-height: 30px;
                }
                .theme-bg{
                    background-color: {{Auth::user()->shop->setting->theme()}};
                }
               .btn{
                    color: #fff;
                    padding: 10px 30px;
                    text-decoration: none;
                    border-radius: 5px;
                    border: none;
               }    
               .btn:hover{
                text-decoration: none;
               }
               .text-center{
                   text-align: center;
               }
            </style>
        </head>
        <body>
            <p><strong>{{$staff->fullname()}}</strong>, your position in {{$staff->shop->name}} is now <strong>{{$position}}</strong>
            Here is your new login credentials</p>
            <ul>
                <li>Email: {{$staff->email}}</li>
                <li>Password: {{$password}}</li>
            </ul>
           
            <div class="text-center">
                <p>You can <a href="{{url('/')}}">login here</a></p>
                <a href="{{url('/')}}" class="btn theme-bg">Login now</a>
            </div>
            <div class="text-center">
                <p>You can change your password if you wish at any time</p>
                <a href="{{route('user.password.edit')}}" class="btn theme-bg">change password</a>
            </div>
            <div style="margin-top: 20px">
                We wish you well,
                <br>
                <strong>{{config('app.name')}}</strong>
            </div>
            <hr>
            <div class="theme-bg text-center" style="margin-top: 30px;color: #fff; padding: 30px 10px">
               This email is intended for <strong>{{$staff->fullname()}}</strong>, If you can not relate to this email, kindly disregard!
            </div>

        </body>
    </html>
