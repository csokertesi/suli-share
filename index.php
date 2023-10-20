<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Csokertesi's server</title>
    <style>
        *{margin:0;padding:0;box-sizing: border-box; font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;}
        body{background-color: #ccc5;}
        header{
            background-color: rgb(24, 198, 20);
            box-shadow: 0 3px 5px rgba(0,0,0,0.4);
            padding: .5rem;
            color: white;
            font-weight: bold;
            letter-spacing: 1px;
            text-align: center;
        }

        .post
        {
            background-color: white;
            box-shadow: 0 3px 5px rgba(0,0,0,0.4);
            padding: 1rem;
            margin: 1rem;
            border-radius: 5px;
        }

        /* place .post1 and .post2 next to each other when the screen is above a set size, and under each other when it's not */
        @media only screen and (min-width: 800px)
        {
            .post1{float: left; width: 46%;}
            .post2{float: right; width: 46%;}
        }

        /* center them horizontally */
        @media only screen and (max-width: 800px)
        {
            .post1{width: 80%; margin: 1rem; padding-right: 0; margin-left: auto; margin-right: auto;}
            .post2{width: 80%; margin: 1rem; padding-right: 0; margin-left: auto; margin-right: auto;}
    
        }

        /* make .post1 and .post2 inside the main tag always have the same height */
        main
        {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            align-items: stretch;
        }

        .post h2
        {
            font-size-adjust: 1.5rem;
        }

        ul{
            padding-top: 0rem;
            list-style-type:none;
        }

        ul li[file]
        {
            padding: .25rem;
        }

        nofiles{
            color: gray;
            font-style: italic;
        }

        #password{
            text-indent: 2px;
            border: 1px solid gray;
            border-radius: 5px;
            padding: .25rem;
            margin-left: .5rem;
            outline: none;
        }

        input[type="submit"]
        {
            border: none;
            background-color: rgb(24, 198, 20);
            color: white;
            padding: .5rem;
            border-radius: 5px;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.4)
        }

        input[type="file"]
        {

        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>CSOKERTESI</h1>
        </nav>
    </header>

    <main>
        <div class="post post1">
            <h2>File access</h2>
            <br>
            <ul id="filelist">
                <?php
                    $files = scandir("./Exports");
                    $hasFiles = false;
                    foreach ($files as $file)
                    {
                        if ($file == "." || $file == "..") continue;
                        echo "<li><a tabindex=\"-1\" download href=\"/Exports/$file\">$file</a></li>";
                        $hasFiles = true;
                    }
                    if (!$hasFiles) echo "<nofiles>No files in Exports</nofiles>";
                ?>
            </ul>
        </div>
        <div class="post post2">
            <h2>File upload</h2>
            <br>
            <form method="POST" action="/upload.php" enctype="multipart/form-data">
                <label for="password">Enter upload password: </label>
                <input type="password" name="password" id="password" required><br><br>
                <input type="file" name="file" id="file"><br><br>
                <input type="submit" value="Upload"><br><br>
                <?php
                    if (isset($_GET['error'])) {
                        $error = $_GET['error'];
                        echo "<small style='color: red;'>$error</small>";
                    } else if (isset($_GET['success'])) {
                        $success = $_GET['success'];
                        echo "<small style='color: green;'>$success</small>";
                    }
                ?>
            </form>
        </div>
    </main>
</body>
<script>
    window.onload = () => {
        // Convert file tags to li tags with a hyperlink pointing to /files/<name>
        let tags = document.querySelectorAll("ul li[file]");

        let hasFiles = false;
        for (let i = 0; i < tags.length; i++) 
        {
            let element = tags.item(i);
            let name = element.getAttribute("name");
            let url = `/file.php?name=${name}`;
            element.innerHTML = `<a href="${url}">${name}</a>`;
            hasFiles = true;
        }
    }
</script>
</html>