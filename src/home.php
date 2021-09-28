<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="images/favicon.ico" type="image/ico">
        <title>datasol</title>
        <link rel="stylesheet" href="home.css">
    </head>

    <body>
        <div class="hero">
            <div class="header">datasol</div>

            <div class ="form-box">
                <div class="button-box">
                    <div id="btn"></div>
                    <button type="button" class="toggle-btn" name="login-toggle" onclick="login()">Log in</button>
                    <button type="button" class="toggle-btn" name="register-toggle" onclick="register()">Register</button>
                </div>
                <form id="login" class="input-group" action="login.php" method="POST">
                    <div class="box">
                        <select name="type">
                            <option value="-1" hidden>Select User Type</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <input type="text" class="input-field" placeholder="Username" name="un1" required>
                    <input type="password" class="input-field" placeholder="Password" name="pwd1" required>
                    <button type="submit" class="submit-btn" name="login-submit">Log in</button>
                </form>
                <form id="register" class="input-group" action="register.php" method="POST">
                    <input type="text" class="input-field" placeholder="Username" name="un2" required>
                    <input type="password" class="input-field" pattern="(?=.*\d)(?=.*[#,$,*,&,@])(?=.*[A-Z]).{8,}" placeholder="Password" name="pwd2" required>
                    <input type="password" class="input-field" placeholder="Confirm Password" name="pwd2-confirm" required>
                    <input type="email" class="input-field" placeholder="E-mail" name="email" required>
                    <button type="submit" class="submit-btn" name="register-submit">Register</button>
                </form>
            </div>

            <script>
                var x = document.getElementById("login");
                var y = document.getElementById("register");
                var z = document.getElementById("btn");

                function register(){
                    x.style.left = "-400px";
                    y.style.left = "50px";
                    z.style.left = "110px";
                }

                function login(){
                    x.style.left = "50px";
                    y.style.left = "450px";
                    z.style.left = "0";
                }
            </script>
        </div>
    </body>
</html>