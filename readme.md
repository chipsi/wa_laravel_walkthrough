# Ukázka použití frameworku Laravel

Tento projekt vznikl pro předmět WA na PEF MENDELU. Tento průvodce ukáže základní použití frameworku Laravel pro
vytvoření aplikace, která zhruba odpovídá části zadání z předmětu APV (tedy evidence osob a jejich adres).

## Úvod

### Platné pro:
- Laravel 5.4.x - [dokumentace](https://laravel.com/docs/5.4/)
- Apache 2.x a PHP 7.0
- NetBeans (volitelné)

### Co je nutné udělat před vlastní prací
- nainstalovat [Composer](https://getcomposer.org/) tak, aby šel spouštět příkazem `composer` z příkazového řádku
- nastavit PHP tak, aby šlo spustit v příkazovém řádku zadáním příkazu `php` (nastavit cestu k PHP do systémových
  proměnných)
- volitelně i [NodeJS](https://nodejs.org/) a balíčkovací systém npm (také by mělo jít spustit přes příkazový řádek)
- volitelně i [Git](https://git-scm.com/)

## Vlastní walkthrough

### Instalace a zahájení projektu
- vytvořte si složku pro projekt
- [stažení frameworku](https://laravel.com/docs/5.4/installation#installing-laravel) pomocí Composeru, použít příkaz
  `composer create-project --prefer-dist laravel/laravel .` (vč. tečky na konci - tzn. do aktuálního adresáře). Složka,
  kam projekt vytváříte **musí** být prázdná.
- spustit příkaz `php artisan key:generate` (nastaví do souboru .env klíč aplikace [použitý k šifrování](https://laravel.com/docs/5.4/installation#configuration))
- nyní je dobré založit projekt v NetBeans nebo jiném IDE
- na lokálním webovém serveru zkontrolovat, že aplikace běží (otevřít složku [http://locahost/laravel_demo/public](http://locahost/laravel_demo/public),
  mělo by se zobrazit jméno frameworku s odkazem na dokumentaci - welcome obrazovka).

Může být nutné nastavit direktivu `RewriteBase` v souboru `/public/.htaccess` na aktuální cestu k aplikaci
např. `RewriteBase /~user/aplikace/public`.

Framework se z Composeru stáhnul vč. připravených šablon, controllerů a migrací pro přihlašování, registrací uživatel a
reset hesla. Pokud je nepotřebujeme, smažeme ze složky `/database/migrations` oba soubory s migracemi a složku
`/app/Http/Controllers/Auth`. Zatím je tam nechte.

Důležité adresáře a soubory:

- `/app`
	- `/Console` - zde jsou uloženy vlastná příkazy pro Artisan (CLI)
	- `/Http` - webová část aplikace
	- `/Controllers` - kontrolery
- `/config` - konfigurace různých součástí a funkcí frameworku (některé konfigurace jsou navíc importovány z /.env
  souboru - např. v /config/database.php najdete v konfiguraci MySQL volání funkce env(), která natáhne lokální
  konfigurace ze souboru /.env). Toto je výhodné pro nasazení aplikace v různých prostředích, lokálně chcete mít jiné přihlašovací údaje do DB než na vašem serveru.
- `/database`
	- `/migrations` - migrační skripty databáze
	- `/seeds` - zde mohou být skripty pro naplnění DB testovacími daty
- `/public` - veřejná část aplikace, to co je opravdu přístupné přes HTTP
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
- `/package.json` - informace o verzích knihoven pro npm. Přes příkaz `npm install` lze tyto knihovny stáhnout a `npm run watch`
  se spustí Webpack a bude hlídat změny v resources/assets adresáři a vytvoří v public/js a public/css odpovídající minifikované soubory.
- `/webpack.mix.js` - nastavení webpack

### JavaScriptové knihovny vyřeším jinak...
Někdy není potřeba mít Bootstrap v SASS zdrojácích apod. Potom smažte `/package.json`, `/resources/assets`,
`/webpack.mix.js` a případně i složku `/node_modules`, pokud už existuje. Ve složce `/public` můžete smazat obsah složek
`css` a `js`. Vlastní JavaScriptové knihovny potom můžete dát přímo do složky `/public` nebo vyřešit jinak (např. přes
Bower).

### Volitelné: Git
Nyní je dobrá chvíle udělat první commit do Gitu. Spusťte `git init` a do `.gitignore` přidejte složku `/nbproject`,
nebo jinou podle vašeho IDE. Soubor `.gitignore` už je v projektu nachystán a měl by obsahovat cesty k adresářům,
které framework nepotřebuje verzovat. Práci commitujte průběžně příkazy `git add .`, `git commit -m "..."` a pokud máte i
vzdálený repositář, tak i `git push`.

### Databáze
Databáze se ve frameworku Laravel nasadí pomocí [migrací](https://laravel.com/docs/5.4/migrations). Není tedy potřeba
téměř spouštět nástroj Adminer nebo phpMyAdmin, samozřejmě je nutné nějak vytvořit vlastní databázi a je dobré
zkontrolovat výsledek migrací. Heslo, login a název databáze se nastaví v souboru `/.env`:

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

### Vytvoření modelové vrstvy
V konzoli opět použijme Artisan CLI k vytvoření skriptů [modelů](https://laravel.com/docs/5.4/eloquent):
`php artisan make:model Models/Person` a `php artisan make:model Models/Location`. Tyto příkazy vytvoří ve složce
`/app/Models`, kde budou třídy pro ORM v namespace `App\Models`. Zde již používáme jednotné číslo pro název modelu
(model automaticky hledá data v tabulce stejného názvu v množném čísle - jen u třídy `Person` je nutné nastavit tabulku
ručně, neboť množné číslo slova "person" je správně "people"). V modelových třídách se jen definuje spojení 1:N mezi
entitou `Person` a `Location` pomocí metod `$this->belongsTo()` (pro načtení adresy k osobe) a `$this->hasMany()`
(pro načtení osob k adrese).

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/5afa185ae5b4a14903fc415d9056c81678734fbf)

### Výpis osob
Vložte pomocí Admineru nebo phpMyAdminu do databáze záznamy o nějakých osobách. Vytvoříme
[kontroler](https://laravel.com/docs/5.4/controllers) a šablonu, která data vypíše. Příkazem
`php artisan make:controller PersonList` vznikne ve složce `/app/Http/Controllers` soubor `PersonsList.php`. Zde můžeme
nadefinovat libovolnou metodu, kterou následně zpřístupníme pomocí webového routeru.

Do složky `/resources/views` vytvořte složku `persons` a tam vložte soubor `list.blade.php`:

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/0776f23292a53105291c76bfad1c2b12476378e5)

Nakonec je potřeba akci zpřístupnit přes [routu](https://laravel.com/docs/5.4/routing) - v souboru `/routes/web.php`
přidejte řádek `Route::get('/osoby', 'PersonsList@show')->name('person::list');`;

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/d6e3c44c91e228a0d39d5eae1af8eb46c110fd30)

Metoda `name` nastaví routě jméno, pomocí kterého můžeme na tuto routu generovat odkazy pomocí funkce
`route(název, parametry = [])` - toto funguje i v šablonách, např.: {{route('person::list')}}. Výhoda je, že cestu
můžeme změnit, ale název routy zůstane, takže jej není nutno dodatečně dohledávat a měnit.

### Smazání osoby
Do šablony vložíme formulář s JavaScriptovým potvrzením. Tento formulář bude vykreslen v každém řádku tabulky a odešle
ID osoby, která má být smazána. V routingu přidáme tentokrát POST routu na metodu delete kontroleru PersonsList.
Laravel automaticky vyžaduje vložení [pole s ochranou proti CSRF](https://laravel.com/docs/5.4/helpers#method-csrf-field)
přes funkci `{{ csrf_field() }}`. Jinak nejde formulář metodou POST odeslat.

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/fffdfc0f21941389a15e52a55097f317f0b7f1b6)

### Přidání nové osoby
Tato akce vyžaduje dvě routy, jednu GET pro zobrazení editačního formuláře a druhou POST pro vlastní uložení osoby.
Nezapomeňte vložit pole pro ochranu proti CSRF.

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/f1a927518eafd60c4bba92def65211de46d321f4)

### Nastavení výchozí routy
Framework sice reaguje na cesty jako `/public/osoby` nebo `/public /osoby/vytvorit`, ale stále vrací výchozí welcome
stránku při otevření `/public`. Nastavením následujícího kódu místo výchozí šablony `welcome` přesměrujeme návštěvníka
na výpis osob (šablonu `/resources/views/welcome.blade.php`):

	Route::get('/', function () {
		return redirect(route('person::list'));
	});

### Validace formuláře pro vložení osoby
Aktuálně máme v aplikaci velice jednoduchý způsob ověření, že data na backend byla poslána v pořádku a vůbec neřešíme
možný problém s unikátností klíče (nickname, first_name, last_name). Laravel podporuje
[validaci formulářů podle daných pravidel](https://laravel.com/docs/5.4/validation#form-request-validation):

	private $formRules = [
		'nickname' => 'required|max:100',
        'first_name' => 'required|max:100',
        'last_name' => 'required|max:100',
		'id_location' => 'integer|nullable|exists:locations,id'
    ];

Validačních pravidel je na [výběr mnoho](https://laravel.com/docs/5.4/validation#available-validation-rules). Pravidlo
[exists](https://laravel.com/docs/5.4/validation#rule-exists) nebo [unique](https://laravel.com/docs/5.4/validation#rule-unique)
dokonce umí nahlédnout do databáze. Bohužel neexistuje pravidlo pro kontrolu unikátnosti přes více sloupců.

Framework při validaci automaticky zastaví provádění metody kontroleru pokud dojde k chybě. Zobrazí pak stránku s
formulářem (vrátí se). Výpis chyb je nutné vložit ručně do šablony `create.blade.php`:

	@if (count($errors) > 0)
	<div>
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif

Taky je dobré do formuláře vložit data z předchozího vyplnění pomocí helper funkce [`old($input, $default = "")`](https://laravel.com/docs/5.4/helpers#method-old):

	<input type="text" name="first_name" value="{{old('first_name')}}" />

	<option value="{{$loc->id}}" @if(old('id_location') == $loc->id) selected @endif>
		...
	</option>

Hlášky s chybami můžete nastavit přímo do metody `validate` jako třetí parametr (klíče jsou názvy validačních pravidel
a v hláškách lze používat zástupné symboly, např.: `:attribute` pro vložení názvu pole) nebo v globálních překladech
v souboru `resources/lang/cs/validation.php` - tento soubor musíte vytvořit, můžete vycházet z anglické verze.
Nejprve je samozřejmě nutné v konfiguraci aplikace `/config/app.php` [nastavit jazyk aplikace na `cs`](https://github.com/lysek/wa_laravel_walkthrough/commit/ee2e46d32e6324adab709e8a1259ee062624e854):

	'locale' => 'cs',

Dalším krokem je ošetření pokusu o vložení duplicitních dat. Tuto chybu zjistíme až při pokusu o vložení do databáze
a je nutné vyvolanou vyjímku zachytit (pozor na lomítko před Exception - třída Exception je v kořenu jmenných prostorů):

	try {
		$p = new Person();
		$p->nickname = $r->get('nickname');
		$p->first_name = $r->get('first_name');
		$p->last_name = $r->get('last_name');
		$p->id_location = $r->get('id_location');
		$p->save();
	} catch(\Exception $e) {
		return redirect(route('person::create'))->withInput($r->all)->with('duplicate_err', 'true');
	}

Při této chybě přesměrujeme zpět na formulář s původním vstupem a příznakem pro zobrazení hlášky o duplicitě:

	@if (session('duplicate_err'))
	<div class="alert alert-success">
		V databazi uz takovyto zaznam je.
	</div>
	@endif

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/c99ddca14f8a7ca21e2ed5bb7d11060279253d55)

### Zobrazení potvrzení o vložení osoby
Metoda `withInput` a `with` u přesměrování využívá session. Dá se použít i k zobrazení potvrzovací zprávy o vložení
osoby. Tento mechanismus se obecně nazíva "flash zprávy".

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/2402251e6ce636f7fc1e84befdf421c58a941175)

### Vytvoříme layout a použijeme Bootstrap a jQuery
Vytvoříme [layout](https://laravel.com/docs/5.4/blade#template-inheritance) stránky ve složce `/resources/views` pod
názvem `layout.blade.php`. Vložíme zde základní strukturu stránky a připojíme [jQuery](http://jquery.com/)
a [Bootstrap](http://getbootstrap.com) z CDN. Kdybychom Bootstrap chtěli mít na svém hostingu, uložíme jej někam do
složky public (např. `/public/css/bootstrap`). V hlavičce bychom potom soubor linkovali pomocí funkce
[asset()](https://laravel.com/docs/5.4/helpers#method-asset), která vygeneruje správnou cestu do složky public.

	<link rel="stylesheet" href="{{asset('css/app.css')}}">

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/1be064d92156a8f0fad8a1a0c31d8f34114d5e99)

Layout vlastně vytvoří místa, kam ostatní šablony mohou vkládat svůj kód.

### Autorizace uživatel do aplikace
Příkazem `php artisan make:auth` se v adresářové struktuře objeví šablony pro přihlašování. V routeru se automaticky
nastaví routy nutné pro přihlašování, registraci, reset hesla apod pomocí `Auth::routes()`. Stejně tak se objeví
v `/resources/views/auth` odpovídající šablony. Laravel vytvoří i HomeController a šablonu pro něj, ty můžeme smazat,
ale bude potřeba v `/app/Http/Controllers/Auth/LoginController.php`, `ResetPasswordController.php`
a `RegisterController.php` nastavit kam se má přesměrovat po přihlášení (zde bohužel nelze použít helper `route(...)`):

	protected $redirectTo = '/osoby';

Dále je toto nutné nastavit v middleware `/app/Http/Middleware/RedirectIfAuthenticated.php`:

	if (Auth::guard($guard)->check()) {
		return redirect(route('person::list'));
	}

To, která stránka bude nebo nebude chráněna přihlašováním se určuje v routeru, přesuneme tedy všechny routy do skupiny
a této nastavíme `middleware` na `auth`:

	Route::group(['middleware' => 'auth'], function () {
		Route::get('/osoby', 'PersonsList@show')->name('person::list');
		Route::post('/osoby/smazat/{id}', 'PersonsList@delete')->name('person::delete');

		Route::get('/osoby/vytvorit', 'PersonsList@create')->name('person::create');
		Route::post('/osoby/pridat', 'PersonsList@insert')->name('person::insert');
	});

Je dobré přeložit šablony ve složce `/resources/views/auth` a použít vlastní layout. Pozor na to, že odhlášení by se
mělo dělat metodou POST (aby vás útočník nemohl odhlásit GET metodou při návštěvě libovolné stránky).

[Zdrojové kódy](https://github.com/lysek/wa_laravel_walkthrough/commit/a9a66f9b1dc98e7031429d5f895f5140a5668bb3)

## Poznámky

### Rozjetí projektu na jiném stroji (po stažení z Gitu)
Příkazem `git clone http://adresa.repositare.cz/nazev.git slozka` se vám stáhne z Gitu kopie projektu. Jelikož jsou
některé důležité soubory a složky nastavené v souboru `.gitignore`, je potřeba primárně spustit příkaz
`composer install`, aby se stáhl vlastní framework a jeho knihovny.

### Posílání emailů
Pro posílání emailů je nutné v souboru `.env` nastavit správně SMTP server. Pro testování odesílání je nejlepší stáhnout
lokální SMTP server (např. [Papercut](https://papercut.codeplex.com/) pro Windows). Na Linuxu lze zase snadno
nakonfigurovat SMTP server pro posílání pošty pouze na lokálním počítači. Jinak se dá použít SMTP od Google/Seznam apod.

# TODO
- seedovani DB
- editace osoby
- testy?