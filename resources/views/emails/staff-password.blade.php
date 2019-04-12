
    <p>
    Hello {{$staff->fullname()}},
    Here is your login details to the {{$staff->shop->name}} {{url('/')}}</p>
    <p>Email: {{$staff->email}}</p>
    <p>Password: {{$password}}</p>
    <p>Note that you can change your password at any time</p>
