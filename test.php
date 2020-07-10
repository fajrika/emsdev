<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        dir {
            padding-left: 0;
        }
    </style>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <form>
        <textarea id="command" class="col-md-10 col-md-offset-1" name="command" cols="30" rows="10"></textarea>
        <br>
        <div class="col-md-12">
            <button class="col-md-2 col-md-offset-5">Submit</button>
        </div>
        <div id='hasil' class="col-md-12">

            <table class="col-md-12 table table-strip">
                <thead>
                    <tr>
                        <th>Command</th>
                        <th>result</th>
                    </tr>
                </thead>
                <tbody id='tbody'>

                </tbody>
            </table>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        abc = '';
        $("form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                data: {
                    command: $("#command").val()
                },
                url: "test2.php",
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    data = "<tr><td>" + $("#command").val() + "</td><td><pre>" + data + "</pre></td></tr>";
                    console.log(data);
                    data = data + $("#tbody").html();
                    $("#tbody").html(data);
                }
            });
        });
    </script>
</body>

</html>