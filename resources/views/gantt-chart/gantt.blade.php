
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
 
    <script src="{{ url(asset('js/dhtmlxgantt.js')) }}"></script>
    <link rel="stylesheet" href="{{ url(asset('css/dist/dhtmlxgantt.css')) }}">
    
    <style type="text/css">
        html, body{
            height:100%;
            padding:0px;
            margin:0px;
            overflow: hidden;
        }

    </style>
</head>
<body>
<div id="gantt_here" style='width:100%; height:100%;'></div>
<script type="text/javascript">
    gantt.config.date_format = "%Y-%m-%d %H:%i:%s";
    gantt.init("gantt_here");
    gantt.load("/api/data");
</script>
</body>