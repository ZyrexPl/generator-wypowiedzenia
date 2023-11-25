<section class="panel">
  <div class="container">
    <div class="row justify-center">
      <h2>Firmy</h2>
    </div>
    <a class="modal-open" href="#modal">Dodaj firmę</a>
    <div id="modal" class="modal">
      <div class="modal-overlay"><a href="#close"></a></div>
      <div class="modal-content">
      <form action="/dyrektor/?firmy" method="post" id="formularz">
        <input type="hidden" id="dodaj" name="dodaj" value="firma">
        <div class="form-group">
          <label for="fname1" class="required"><span class="field-name">Nazwa</span> <strong class="required">(*)</strong></label>
          <input class="form-control" id="nazwa" name="nazwa" type="text" autocomplete="given-name" required="required" data-rule-minlength="2" />
        </div>
        <div class="form-group">
          <label for="fname1" class="required"><span class="field-name">Url</span> <strong class="required">(*)</strong></label>
          <input class="form-control" id="url" name="url" type="text" autocomplete="given-name" required="required" data-rule-minlength="2" />
        </div>
        <div class="form-group">
          <label for="opis"><span class="field-name">Opis</span> </label>
          <textarea id="opis" name="opis" rows="4" cols="50" class="form-control"></textarea>
        </div>
        <div class="form-group">
			    <label for="kategoria" class="required"><span class="field-name">Kategoria</span> <strong class="required">(*)</strong></label>
			    <select class="form-control" id="kategoria" name="kategoria" autocomplete="honorific-prefix" required="required">
				     <option value="1">Ubezpieczenia</option>
				     <option value="2">Telekomunikacja</option>
				     <option value="3">Energia</option>
				     <option value="4">Fitnass</option>
			    </select>
		    </div>
        <div class="form-group">
          <label for="adres1"><span class="field-name">Adres1 (pełna nazwa firmy)</span></label>
          <input class="form-control" id="adres1" name="adres1" type="text" autocomplete="given-name" data-rule-minlength="2" />
        </div>
        <div class="form-group">
          <label for="adres2"><span class="field-name">Adres2</span></label>
          <input class="form-control" id="adres2" name="adres2" type="text" autocomplete="given-name" data-rule-minlength="2" />
        </div>
        <div class="form-group">
          <label for="adres3"><span class="field-name">Adres1</span></label>
          <input class="form-control" id="adres3" name="adres3" type="text" autocomplete="given-name" data-rule-minlength="2" />
        </div>
        <div class="form-group">
          <input type="submit" value="Dodaj firmę" class="button btn-wyslij">
        </div>
      </form>
    </div>
    </div>
    <div class="row">
      <h3>Ostatnio dodane</h3>
    </div>
    <div class="row">

      <table>
        <tr>
          <th>Nazwa</th>
          <th>Kategoria</th>
          <th>Url</th>
          <th>Adres1</th>
          <th>Adres2</th>
          <th>Adres3</th>
          <th> </th>
        </tr>
        {foreach $firmy as $firma}
        <tr>
          <td>{$firma.f_nazwa}</td>
          <td>{$firma.k_nazwa}</td>
          <td>{$firma.f_url}</td>
          <td>{$firma.f_adres1}</td>
          <td>{$firma.f_adres2}</td>
          <td>{$firma.f_adres3}</td>
          <td class="text-center"><a class="modal-open" href="#usun{$firma.fid}">usuń</a></td>
          <div id="usun{$firma.fid}" class="modal">
            <div class="modal-overlay"><a href="#close"></a></div>
            <div class="modal-content">
              <h3>Czy na pewno chcesz usunąć {$firma.f_nazwa}?</h3>
              <form action="/dyrektor/?firmy" method="post">
                <input type="hidden" id="firma" name="firma" value="delete">
                <input type="hidden" id="fid" name="fid" value="{$firma.fid}">
                <div class="form-group">
                  <input type="submit" value="Tak" class="button btn-wyslij">
                </div>
              </form>
            </div>
          </div>
        </tr>
        {/foreach}
      </table>

    </div>
  </div>
</section>
