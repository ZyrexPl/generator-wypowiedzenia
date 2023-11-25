{foreach $firmadane as $firmad}
<section class="naglowek">
  <div class="container">
    <div class="row justify-center">
      <a href="/">wypowiedzenieumowy.org</a>
    </div>
    <div class="row justify-center">
      <p>Z nami wypowiedzenie umowy jest prostsze</p>
    </div>
  </div>
</section>
<section class="wyszukiwarka">
  <div class="container">
    <div class="row justify-center">
      <h1>Wypowiedzenie umowy {$firmad.f_nazwa}</h1>
    </div>
  </div>
</section>
<section class="firma-generuj-pdf">
  <div class="container">
    <div class="row">
      <p><a href="/">Home</a> -> <a href="/{$firmad.k_nazwa}">{$firmad.k_nazwa}</a> -> {$firmad.f_nazwa}</p>
    </div>
    <div class="row">
      <p><span class="niebieski">{$firmad.f_nazwa}</span> - {$firmad.f_opis}</p>
    </div>
    <div class="row">
      <p>Aby wygenerować wypowiedzenie wypełnij poniższy formularz</p>
    </div>
    <div class="row">
      <div class="wb-frmvld">
        <form action="/dziekujemy" method="post" id="formularz">
          <input type="hidden" id="fid" name="fid" value="{$firmad.fid}">
          <input type="hidden" id="zamowienie" name="zamowienie" value="dodaj">
          <div class="form-group">
            <label for="data"><span class="field-name">Data wypowiedzenia</span> (np. 10.06.2022)</label>
			      <input class="form-control" id="data" name="data" type="date" autocomplete="date" />
          </div>
          <div class="form-group">
            <label for="polisa" class="required"><span class="field-name">Numer polisy</span> <strong class="required">(*)</strong></label>
            <input class="form-control" id="polisa" name="polisa" type="text" autocomplete="given-name" required="required" data-rule-minlength="2" />
          </div>
          <div class="form-group">
            <label for="imie" class="required"><span class="field-name">Imię</span> <strong class="required">(*)</strong></label>
            <input class="form-control" id="imie" name="imie" type="text" autocomplete="given-name" required="required" data-rule-minlength="2" />
          </div>
          <div class="form-group">
            <label for="nazwisko" class="required"><span class="field-name">Nazwisko</span> <strong class="required">(*)</strong></label>
            <input class="form-control" id="nazwisko" name="nazwisko" type="text" autocomplete="given-name" required="required" data-rule-minlength="2" />
          </div>
          <div class="form-group">
            <label for="ulica" class="required"><span class="field-name">Ulica i numer budynku</span> <strong class="required">(*)</strong></label>
            <input class="form-control" id="ulica" name="ulica" type="text" autocomplete="given-name" required="required" data-rule-minlength="2" />
          </div>
          <div class="form-group">
            <label for="kod" class="required"><span class="field-name">Kod pocztowy</span> <strong class="required">(*)</strong></label>
            <input class="form-control" id="kod" name="kod" type="text" autocomplete="given-name" required="required" data-rule-minlength="2" />
          </div>
          <div class="form-group">
            <label for="miasto" class="required"><span class="field-name">Miasto</span> <strong class="required">(*)</strong></label>
            <input class="form-control" id="miasto" name="miasto" type="text" autocomplete="given-name" required="required" data-rule-minlength="2" />
          </div>
          <div class="form-group">
            <label for="email"><span class="field-name">Email</span> (np. twojanazwa@domena.com)</label>
			      <input class="form-control" id="email" name="email" type="email" autocomplete="email" />
          </div>
          <div class="form-group">
				    <div class="checkbox checkbox-standalone required">
					     <label for="agree1"><input id="agree1" name="agree1" type="checkbox" required> <span class="field-name">Akceptuję <a href="/regulamin">regulamin serwisu</a></span> <strong class="required">(*)</strong></label>
				    </div>
			    </div>
          <div class="form-group">
            <input type="submit" value="Generuj PDF" class="button btn-wyslij">
          </div>
        </form>
      </div>
      <div class="podglad">
        <h3>Podgląd</h3>
        <div class="podgląd-dokumentu">
          <div class="daneosobowe">
            <p><span id="zobaczImie"></span> <span id="zobaczNazwisko"></span></p>

          </div>
          <div class="dane-firmy">
            <p>{$firmad.f_adres1}</p>
            <p>{$firmad.f_adres2}</p>
            <p>{$firmad.f_adres3}</p>
          </div>
          <div class="trest-wypowiedzenia">
            <h3>Wypowiedzenie umowy</h3>
            <p>Treść wypowiedzenia ... z dniem <span></span></p>
          </div>
          <div class="podpis">
            <p>...................<p>
            <p>Podpis</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
{/foreach}
<script>
const imie = document.querySelector("#imie");
const pokazImie = document.getElementById('zobaczImie');
imie.addEventListener("change", (event) => {
  const inputValue = event.target.value;
//  console.log(inputValue);
  pokazImie.textContent = inputValue;
});

const nazwisko = document.querySelector("#nazwisko");
const pokazNazwisko = document.getElementById('zobaczNazwisko');
nazwisko.addEventListener("change", (event) => {
  const inputValue = event.target.value;
//  console.log(inputValue);
  pokazNazwisko.textContent = inputValue;
});
</script>
