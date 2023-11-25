<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="author" content="Zyrex" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{if isset ($title)}{$title} | {/if}Wypowiedzenie umowy</title>

        <!-- Custom styles for this template-->
        <link href="/css/style.css" rel="stylesheet">

    </head>
    <body>
    {if isset ($serwis)}
    {$serwis}
    {if isset($stopka)}{$stopka}{/if}
    {else}
    {if isset($menu)}{$menu}{/if}
    <div id="wrapper">
        {$main}
    </div>
    {/if}

</body>
</html>
