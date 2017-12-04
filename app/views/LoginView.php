<!doctype html>

<html lang="en">

    <head>
        <title>Log In</title>
    </head>

    <body>

        <h1>Log In</h1>

        <?= $this -> _('navigation'); ?>

        <?= $this -> _('flash'); ?>

        <section>
            <?= $this -> Helpers -> Form -> create('post', $this); ?>
                <?= $this -> Helpers -> Form -> textbox('email', [
                    'placeholder' => 'E-mail Address'
                ]); ?>
                <?= $this -> Helpers -> Form -> password('password', [
                    'placeholder' => 'Password'
                ]); ?>
                <?= $this -> Helpers -> Form -> submit('Log In', 'login'); ?>
            <?= $this -> Helpers -> Form -> end(); ?>
        </section>

    </body>

</html>
