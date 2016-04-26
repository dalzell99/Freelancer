<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Reset Password</title>

        <?php include('head.php');
        echo '<script type="text/javascript" src="js/reset-password.js?' . filemtime('js/reset-password.js') . '"></script>';
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
                        IMF’s Portal is always open for you to keep your details up to date or view important documents relating to your claim.
                    </p>

                    <p>
                        If you have forgotten your password, enter your email address below and a new temporary password will be sent to you inbox immediately. You will be asked to change this temporary password after login.
                    </p>

                    <table>
                        <tr>
                            <td>
                                <label for'#resetpasswordEmailInput'>Email Address</label>
                            </td>
                            <td>
                                <input id='resetpasswordEmailInput' type='email' />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <!-- Empty -->
                            </td>
                            <td>
                                <button id='resetpasswordButton'>Reset Password</button>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <!-- Empty -->
                            </td>
                            <td>
                                <a href='/index.php'>Return to login</a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <!-- Empty -->
                            </td>
                            <td>
                                <a href='/register.php'>Register new account</a>
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
