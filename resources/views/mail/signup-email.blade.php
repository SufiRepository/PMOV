Hello {{$email_data['username']}}
<br><br>
Welcome To Project Management Office 
<br> 
Please click the below link to verify your email and activate your Account!
<br><br>
<a href="http://staging.pmo.mindwave.my/verify?code={{$email_data['verification_code']}}"> click here </a>
{{-- <a href="http://pmo.mindwave.my/PMO/public/verify?code={{$email_data['verification_code']}}"> click here </a> --}}
{{-- <a href="http://pmo.local/verify?code={{$email_data['verification_code']}}"> click here </a> --}}

<br><br>
Thank you
<br>
