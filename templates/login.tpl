<section class="naglowek text-center">
  <div class="container">
    <div class="row justify-center">
      <h2>wypowiedzenieumowy.org</h2>
    </div>
    <div class="row justify-center">
      <p>Z nami wypowiedzenie umowy jest prostsze</p>
    </div>
  </div>
</section>
<section class="logowanie">
  <div class="container">
    <div class="row">
      <form action="/dyrektor" method="post" id="formularz">
        <input type="hidden" id="logowanie" name="zaloguj" value="zaloguj">
        <div class="form-group">
          <label for="fname1" class="required"><span class="field-name">Login</span> <strong class="required">(*)</strong></label>
          <input class="form-control" id="login" name="login" type="text" autocomplete="given-name" required="required" data-rule-minlength="2" />
        </div>
        <div class="form-group">
          <label for="fname1" class="required"><span class="field-name">Hasło</span> <strong class="required">(*)</strong></label>
          <input class="form-control" id="pass" name="pass" type="password" autocomplete="given-name" required="required" data-rule-minlength="2" />
        </div>
        <div class="form-group">
          <input type="submit" value="Wejdź" class="button btn-wyslij">
        </div>
      </form>
    </div>
  </div>
</section>
