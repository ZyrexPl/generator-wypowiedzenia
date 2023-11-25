<section class="panel">
  <div class="container">
    <div class="row justify-center">
      <h2>Zamówienia</h2>
    </div>
    <div class="row">
      <h3>Ostatnio dodane</h3>
    </div>
    <div class="row">
      <table>
        <tr>
          <th>Firma</th>
          <th>Imię</th>
          <th>Nazwisko</th>
          <th>Płatność</th>
          <th>Status</th>
          <th> </th>
        </tr>
        {foreach $zamowienia as $zamowienie}
        <tr>
          <td>{$zamowienie.f_nazwa}</td>
          <td>{$zamowienie.w_imie}</td>
          <td>{$zamowienie.w_nazwisko}</td>
          <td>{$zamowienie.z_platnosc}</td>
          <td>{$zamowienie.z_status}</td>
          <td><a href="/dyrektor/?wypowiedzenie/{$zamowienie.zid}">Generuj PDF</a></td>
        </tr>
        {/foreach}
      </table>

    </div>

  </div>
</section>
