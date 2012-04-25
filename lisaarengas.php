<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Lisaa uusi vaalirengas</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <p> Lisaa uusi vaalirengas.</p>
        <form name="vaalirengas" action="script.php" method="post">
            <input type="hidden" name="type" value="vaalirengas" />
            Vaalirenkaan nimi: <input type="text" name="nimi" />
            Vaalirenkaan tunnus: <input type="text" name="tunnus" /><br /> <br />
            <input type="submit" value="submit">
        </form>
    </body>
</html>
