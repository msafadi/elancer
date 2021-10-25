<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h2 style="font-family:arial">Hello {{ $notifiable->name }},</h2>

    <p>A new proposal has been added to you porject "{{ $proposal->project->title}} " by {{ $freelancer->name }}</p>

    <p><a href="{{ route('projects.show', $proposal->project_id) }}">View Project</a></p>

    <p>Thank you!</p>
    
</body>
</html>