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
      <h1>{$title}</h1>
    </div>
  </div>
</section>
<section class="wzory-pism">
  <div class="container">
    <div class="row">
      <p><a href="./">Home</a> -> {$title}</p>
    </div>
    <div class="row">
      <h3>Firmy:</h3>
    </div>
    <div class="row">
      {foreach $firmy as $firma}
      <div class="item-firma">
        <a href="/wzor/{$firma.f_url}">{$firma.f_nazwa}</a>
      </div>
      {/foreach}
    </div>
  </div>
</section>
