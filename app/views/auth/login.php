<div class="masthead">
    <h3 class="text-muted">Internetowa Platforma Testowa</h3>
    <ul class="nav nav-justified">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Projects</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Downloads</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</div>

<form class="form-signin" id="signin" action="{baseurl}auth/loginDo" method="post">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="text" name="email" class="form-control" placeholder="Email address" autofocus>
    <input type="password" name="password" class="form-control" placeholder="Password">
    <label class="checkbox">
        <input type="checkbox" value="remember-me"> Remember me
    </label>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
