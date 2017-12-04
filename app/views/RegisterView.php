<!doctype html>

<html lang="en">
    <head>
        <!-- <link rel="stylesheet" type="text/css" href="/css/style.css" /> -->
    </head>

    <body>

        <?= $this -> _('navigation'); ?>

        <?= $this -> _('flash'); ?>

        <?= $this -> Helpers -> Form -> create('post', $this -> interlink(['register', 'index'])); ?>
            <?= $this -> Helpers -> Form -> textbox('email', [
                'placeholder' => 'E-mail Address'
            ]); ?>
            <?= $this -> Helpers -> Form -> textbox('username', [
                'placeholder' => 'Desired Username'
            ]); ?>
            <?= $this -> Helpers -> Form -> password('password', [
                'placeholder' => 'Password'
            ]); ?>
            <?= $this -> Helpers -> Form -> password('confirm_password', [
                'placeholder' => 'Confirm Password'
            ]); ?>
            <?= $this -> Helpers -> Form -> submit('Register', 'register'); ?>
        <?= $this -> Helpers -> Form -> end(); ?>

    </body>
</html>
