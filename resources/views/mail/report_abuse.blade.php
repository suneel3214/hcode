<!DOCTYPE html>
<html>
<head>
    <title>Abuse Issue Report</title>
</head>

<body>
<h2>{{$data->type_of_report}}</h2>

<br/>
<h3>Mr. {{$data->name}} ({{$data->email}}) , has submited abuse report.</h3>
<br/>
<div>
    <p>
        {{$data->message}}
    </p>
</div>
</body>

</html>