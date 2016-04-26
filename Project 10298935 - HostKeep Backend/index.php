<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Portal - Login (IMF)</title>

        <?php include('head.php');
        echo '<link rel="stylesheet" type="text/css" href="css/index.css?' . filemtime('css/index.css') . '" />';
        echo '<script type="text/javascript" src="js/index.js?' . filemtime('js/index.js') . '"></script>';
        ?>
    </head>
    <body>
        <div class='.container-fluid'>
            <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <header>
                    <?php include('header.php'); ?>
                </header>

                <main>
                    <p>
                        Welcome to IMF's secure online tool for clients – <strong>Portal</strong>.
                    </p>

                    <p>
                        Login here to update your details, view important notifications, and download key documents relating to actions being funded by IMF.
                    </p>

                    <p>
                        If you have not already registered for our Client Portal please click the <a href="./register.php">Register</a> link. Then use your email address registered with IMF to create your new Portal account and a temporary password will be emailed to you.
                    </p>

                    <p>
                        If you need further assistance, please call IMF on 1800 016 464 or +61 8 9225 2322 or email us on <a href='mailto:portal@imf.com.au'>portal@imf.com.au</a>
                    </p>

                    <table>
                        <tr>
                            <td>
                                <label for='#loginEmailInput'>Email</label>
                            </td>
                            <td>
                                <input id='loginEmailInput' type='email' />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for='#loginPasswordInput'>Password</label>
                            </td>
                            <td>
                                <input id='loginPasswordInput' type='password' />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <!-- Empty -->
                            </td>
                            <td>
                                <button id='loginButton'>Submit</button>
                            </td>
                        </tr>

                        <!-- Uncomment when forgotten username page done
                        <tr>
                            <td>
                                Empty
                            </td>
                            <td>
                                <a href="./forgot-username.php">Forgot my username</a>
                            </td>
                        </tr>
                         -->

                        <tr>
                            <td>
                                <!-- Empty -->
                            </td>
                            <td>
                                <a href="./reset-password.php">Forgot my password</a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <!-- Empty -->
                            </td>
                            <td>
                                <a href="./register.php">Register new account</a>
                            </td>
                        </tr>
                    </table>
                </main>

                <footer>
                    <?php include('footer.php'); ?>
                </footer>
            </div>
        </div>
    </body>
</html>
