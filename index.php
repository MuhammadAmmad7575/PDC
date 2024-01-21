<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
            color: #333;
        }

        header {
            background-color: #3498db;
            color: #fff;
            padding: 20px;
        }

        h1 {
            margin-bottom: 5px;
        }

        p {
            margin: 10px 0;
        }

        h2 {
            color: #3498db;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            display: inline-block;
            margin-right: 10px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <header>
        <h1>Your Profile</h1>
    </header>

    <div>
        <?php
        // Sample user data
        $user = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'bio' => 'Web Developer',
            'skills' => ['PHP', 'HTML', 'CSS', 'JavaScript'],
            'social' => [
                'twitter' => 'https://twitter.com/johndoe',
                'linkedin' => 'https://www.linkedin.com/in/johndoe',
                'github' => 'https://github.com/johndoe'
            ]
        ];

        // Display user information
        echo "<p>Email: {$user['email']}</p>";
        echo "<p>Bio: {$user['bio']}</p>";

        // Display skills
        echo "<h2>Skills</h2>";
        echo "<ul>";
        foreach ($user['skills'] as $skill) {
            echo "<li>{$skill}</li>";
        }
        echo "</ul>";

        // Display social links
        echo "<h2>Social Links</h2>";
        echo "<ul>";
        foreach ($user['social'] as $platform => $link) {
            echo "<li><a href='{$link}' target='_blank'>{$platform}</a></li>";
        }
        echo "</ul>";
        ?>
    </div>

</body>
</html>