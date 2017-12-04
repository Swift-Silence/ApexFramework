<nav>
    <?= $this -> Helpers -> Link -> create('Home', $this -> interlink(['home', 'index'])); ?>
    <?= $this -> Helpers -> Link -> create('Log In', $this -> interlink(['login', 'index'])); ?>
    <?= $this -> Helpers -> Link -> create('Register', $this -> interlink(['register', 'index'])); ?>
</nav>
