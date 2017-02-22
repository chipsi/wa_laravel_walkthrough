# Ukázka použití frameworku Laravel

Tento projekt vznikl pro předmět WA. Tento průvodce ukáže základní použití frameworku Laravel pro vytvoření aplikace,
která zhruba odpovídá části zadání z předmětu APV (tedy evidence osob a jejich adres).

## Platné pro:
- Laravel 5.4.x - dokumentace https://laravel.com/docs/5.4/
- Apache 2.x a PHP 7.0
- NetBeas (volitelné)

## Co je nutné udělat před vlastní prací
- nainstalovat [Composer](https://getcomposer.org/) tak, aby šel spouštět příkazem `composer` z příkazového řádku
- nastavit PHP tak, aby šlo spustit v příkazovém řádku zadáním příkazu `php` (nastavit cestu k PHP do systémových
  proměnných)
- volitelně i NodeJS a balíčkovací systém npm (také by mělo jít spustit přes příkazový řádek)
- volitelně i Git

## Instalace a zahájení projektu
- vytvořte si složku pro projekt
- stažení frameworku pomocí Composeru, použít příkaz `composer create-project --prefer-dist laravel/laravel .` (vč. tečky
  na konci - tzn. do aktuálního adresáře). Složka, kam projekt vytváříte **musí** být prázdná.
- spustit příkaz `php artisan key:generate` (nastaví do souboru .env klíč aplikace použitý k šifrování)
- nyní je dobré založit projekt v NetBeans nebo jiném IDE
- na lokálním webovém serveru zkontrolovat, že aplikace běží (otevřít složku http://locahost/laravel_demo/public,
  mělo by se zobrazit jméno frameworku s odkazem na dokumentaci).

Může být nutné nastavit direktivu `RewriteBase` v souboru `.htaccess` na aktuální cestu k aplikaci
např. `RewriteBase /~user/aplikace/public`.

Framework se z Composeru stáhnul vč. připravených šablon, controllerů a migrací pro přihlašování, registrací uživatel a
reset hesla. Pokud je nepotřebujeme, smažeme ze složky `/database/migrations` oba soubory s migracemi a složku
`/app/Http/Controllers/Auth`. Zatím je tam nechte.

Důležité adresáře a soubory:
- `/app`
	- `/Console` - zde jsou uloženy vlastná příkazy pro Artisan (CLI)
	- `/Http` - webová část aplikace
	- `/Controllers` - kontrolery
- `/config` - konfigurace různých součástí a funkcí frameworku (některé konfigurace jsou navíc importovány z /.env souboru - např. v /config/database.php najdete v konfiguraci MySQL volání funkce env(), která natáhne lokální konfigurace ze souboru /.env). Toto je výhodné pro nasazení aplikace v různých prostředích, lokálně chcete mít jiné přihlašovací údaje do DB než na vašem serveru.
- `/database`
	- `/migrations` - migrační skripty databáze
	- `/seeds` - zde mohou být skripty pro naplnění DB testovacími daty
- `/public`
- `/resources`
	- `/assets` - zdrojové kódy frontendových knihoven
	- `/lang` - lokalizace
	- `/views` - šablony aplikace
- `/routes` - složka s routingem
- `/web.php` - routy webové aplikace
- `/console.php` - routy pro konzolu (vlastní příkazy pro CLI Artisan)
- `/.env` - lokální nastavení aplikace (na serveru bude možná jiné), neverzuje se (při klonování z gitu je nutné zkopírovat .env.example)
- `/artisan` - php skript realizující konzolu
- `/composer.json` a `composer.lock` - informace o verzích PHP knihoven pro Composer
- `/readme.md` - výchozí readme v markdownu (napište si vlastní)
- `/package.json` - informace o verzích knihoven pro npm. Přes příkaz npm install lze tyto knihovny stáhnout a npm run watch se spustí Webpack a bude hlídat změny v resources/assets adresáři a vytvoří v public/js a public/css odpovídající minifikované soubory.
- `/webpack.mix.js` - nastavení webpack

## JavaScriptové knihovny vyřeším jinak…
Někdy není potřeba mít Bootstrap v SASS zdrojácích apod. Potom smažte `/package.json`, `/resources/assets`,
`/webpack.mix.js` a případně i složku `/node_modules`, pokud už existuje. Ve složce `/public` můžete smazat obsah složek
`css` a `js`. Vlastní JavaScriptové knihovny potom můžete dát přímo do složky `/public` nebo vyřešit jinak (např. přes
Bower).

## Volitelné: Git
Nyní je dobrá chvíle udělat první commit do Gitu. Spusťte `git init` a do `.gitignore` přidejte složku `/nbproject`,
nebo jinou podle vašeho IDE. Práci commitujte průběžně příkazy `git add .`, `git commit -m "..."` a pokud máte i
vzdálený repositář, tak i `git push`.

## Databáze
Databáze se ve frameworku Laravel nasadí pomocí migrací. Není tedy potřeba téměř spouštět nástroj Adminer nebo
phpMyAdmin, samozřejmě je nutné nějak vytvořit vlastní databázi a je dobré skontrolovat výsledek migrací. Heslo, login
a název databáze se nastaví v souboru `/.env`:

	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=wa_walkthrough_laravel
	DB_USERNAME=login
	DB_PASSWORD=heslo

Prohlédněte nastavení znakové sady databáze v souboru `/config/database.php` a ověřte, že je pro MySQL nastaveno
kódování UTF-8:

	...
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
	...

Databázové tabulky pro aplikaci budeme realizovat pomocí migrací. Nové soubory pro migrace vytvoříme příkazem
`php artisan make:migration locations` a `php artisan make:migration persons` (na pořadí záleží, protože určuje, jak
budou migrace spouštěny nad databází).

Napište [migrační skripty](https://github.com/lysek/wa_laravel_walkthrough/commit/8beb35d0e1c8d646fe4f4955408ff2458ab0c16b).

Metoda `$table->timestamps();` přidá do tabulek sloupce s informací o času vytvoření a poslední editaci.

Všimněte si, že názvy tabulek jsou v množném čísle. Nyní příkazem `php artisan migrate` naimportujeme strukturu
databáze. Laravel vytvoří ještě tabulku `migrations`, kam si zapisuje pořadí migrovaných souborů. Pokud bychom chtěli
migrace vzít zpět, použijeme příkaz `php artisan migrate:rollback`. V databázi by se měly objevit tabulky nebo v konzoli
chyba. Pokud došlo k vytvoření jen části databázových tabulek, je nutné smazat z DB vše ručně přes Adminer, opravit
chybu a potom spustit znovu migrace.

## Vytvoření modelové vrstvy
V konzoli opět použijme Artisan CLI k vytvoření skriptů modelů: `php artisan make:model Models/Person`
a `php artisan make:model Models/Location`. Tyto příkazy vytvoří ve složce `/app/Models`, kde budou třídy pro ORM
v namespace `App\Models`. Zde již používáme jednotné číslo pro název modelu (model automaticky hledá data v tabulce
stejného názvu v množném čísle - jen u třídy `Person` je nutné nastavit tabulku ručně, neboť množné číslo slova "person"
je správně "people"). V modelových třídách se jen definuje spojení 1:N mezi entitou `Person` a `Location` pomocí metod
`$this->belongsTo()` (pro načtení adresy k osobe) a `$this->hasMany()` (pro načtení osob k adrese).

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/5afa185ae5b4a14903fc415d9056c81678734fbf)

## Výpis osob
Vložte pomocí Admineru nebo phpMyAdminu do databáze záznamy o nějakých osobách. Vytvořéme kontroler a šablonu, která
data vypíše. Příkazem `php artisan make:controller PersonList` vznikne ve složce `/app/Http/Controllers` soubor
`PersonsList.php`. Zde můžeme nadefinovat libovolnou metodu, kterou zpřístupníme pomocí webového routeru v souboru
`/routes/web.php`.

Do složky `/resources/views` vytvořte složku `persons` a tam vložte soubor `list.blade.php`:

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/0776f23292a53105291c76bfad1c2b12476378e5)

Nakonec je potřeba akci zpřístupnit přes routu - v souboru `/routes/web.php` přidejte řádek
`Route::get('/osoby', 'PersonsList@show')`;

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/d6e3c44c91e228a0d39d5eae1af8eb46c110fd30)

## Smazání osoby
Do šablony vložíme formulář s JavaScriptovým potvrzením. Tento formulář bude vykreslen v každém řádku tabulky a odešle
ID osoby, která má být smazána. V routingu přidáme tentokrát POST routu na metodu delete kontroleru PersonsList.

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/fffdfc0f21941389a15e52a55097f317f0b7f1b6)

## Přidání nové osoby
Tato akce vyžaduje dvě routy, jednu GET pro zobrazení editačního formuláře a druhou POST pro vlastní uložení osoby.

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/f1a927518eafd60c4bba92def65211de46d321f4)

## Autorizace uživatel do aplikace
Příkazem `php artisan make:auth` se v adresářové struktuře objeví šablony pro přihlašování.

# TODO
- pouziti validace formulare pri vkladani osoby
- flash messages
- spolecny layout
- bootstrap CSS
- seedovani DB
- testy?