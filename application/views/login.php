<!DOCTYPE html>
<html>

<head>
    <title>Online</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./../fonts/css/all.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #17a2b8;
            height: 100vh;
        }

        #login .container #login-row #login-column #login-box {
            margin-top: 100px;
            max-width: 600px;
            height: 420px;
            border: 1px solid #9C9C9C;
            background-color: #EAEAEA;
        }

        #login .container #login-row #login-column #login-box #login-form {
            padding: 20px;
        }

        /* #login .container #login-row #login-column #login-box #login-form #register-link {
            margin-top: 85px;
        } */

        /* .text-right {
            margin-left: 60%;
        } */
    </style>
</head>
<body>
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <img src="./dbmci.png" width="25%" alt="" style="border-radius: 20px;margin-left: 180px;margin-bottom: 20px;">
                            <h3 class="text-center text-info">Student Login Form</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="text" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input
                                            id="remember-me" name="remember-me" type="checkbox"></span>
                                </label>
                                <button type="button" class="btn btn-info" style="margin-left: 260px;">submit</button>
                            </div>                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>