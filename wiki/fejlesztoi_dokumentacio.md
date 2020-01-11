# Fejlesztői dokumentáció
## Alapötlet:
Egy űdítő automata szimulálása ahol bankkártyával tudunk fizetni. Minden folyamat sikerességet és egyéb információkat a LED-ek jeleznek vissza.

## Tervezési fázisok:
### 1. Projekt pontosítása, hardver elemek kiválasztása
Itt egy arduino-hoz hasonló mikrokontrollert választottunk NODEMCU, ez egy arduino kompatibilis ESP8266 mikrokontroller beépített WiFi egységgel.
Azért választottuk ezt mert az adatbázis használatához elengedhetetlennek éreztük egy külső "szerver" használatát és ez a WiFi-s megoldást tűnt a legegyszerűbbnek a kettő közötti kapcsolathoz.

#### NODEMCU ESP8266
I/O felület: 3.3V LVTTL

Áramfelvétel: max. 240mA

Tápellátás: MicroUSB-n keresztül

![5cc1e81c-f762-4651-9a1c-0541f0ad80eb](https://user-images.githubusercontent.com/44652322/72210579-bfd39800-34bd-11ea-9423-5f36f5c8bac9.jpg)


A bankkártyás fizetéseket NFC kártyával terveztük szimulálni. 
Amihez egy PN532 NFC modul-t használunk ami egyaránt tud írni/olvasni is tud NFC chipeket, de ez esetben mi csak az olvasó részét használjuk.

#### PN532 NFC modul
Kommunikációs távolság: 5-7cm
Többfajta kommunikációs módot tudunk rajta használni nekünk a legmegfelelőbb az I2C kommunikációs mód megfelelt amihez 4 PIN bekötése szükséges.

- GND -> GND
- VCC -> 3.3V
- SDA -> GPI04
- SCL -> GPI05

![2-PN532-Module-V3_Closeup](https://user-images.githubusercontent.com/44652322/72210637-a717b200-34be-11ea-8b54-fa8020fbdaca.jpg)


### Gomb
Itt egy szimpla 3 PIN-es gombot használunk.
GND12, 3.3V, GND


### LEDEK
3 Ledet a termékek jelzésére használunk 
- Piros led: GPI03, GND
- Zöld led: GPI15, GND
- Kék led: GPI13, GND


3 Ledet pedig az eszköz állapotára, illetve visszajelzéseire.
- Piros led: GPI02, GND
- Kék led: GPI16, GND
- Narancssárga led: GPI01, GND

### 2. Szoftvertervezés
Itt átbeszéltük a főbb funkciókat, hogy mit kéne tudnia az eszköznek és arra jutottunk, hogy a mikrokontroller egy webes API-n keresztül fog egy szerverrel kommunikálni,
és a főbb számítási feladatokat a szerver fogja végezni, míg a mikrokontroller csak adatokat ad át az API-n keresztül.
#### ESP8266 
Az eszköz fejlesztéséhez c++ program nyelvet választottuk, mert ebben láttuk a legtöbb lehetőséget, kompatibilitást.
#### Szerver
A szerveren egy MySQL szerver fut amiben a termékek adatait, a vásárlók bankártyáinak adatait tároljuk.
A webes API-hoz PHP program nyelvet választottuk, itt is ezt láttuk a legegyszerűbb megoldásnak és ez a programnyelv volt általunk ismert.

API Példa:
`http://10.41.0.1/pay.php?uid=KARTYASZAM&product=TERMEKID`

Ahogyan a példában is látható fizetéskor a mikrokontroller a pay.php fájl-t hívja meg és két darab paramétert ad át:
- UID --> A jelenleg vásárló kártyaszámát
- PRODUCT --> Kiválasztott termék sorszámát

Miután megkapta ezeket a paramétereket a php script egy SQL kérést indít ahol lekéri a kártya adatait, a választott termék adatait.
Majd leellenőrzi, hogy a kártyán van-e elegendő pénz, ha van akkor leellenőrzi, hogy az automatában van-e a termékből, hiba esetén e-mail-t küld illetve
a php script modósítja a HTTP header-t

Elfogyott űdítőnél --> `HTTP/1.1 404 Not Found` -re modósítja

Kevés pénznél --> `HTTP/1.1 403 Forbidden` -r modósítja a HTTP header-t

Sikeres fizetés után az eszköz visszaáll alap állapotba.

### Termékek, vásárlók kezelése
Erre a célra készítettünk egy web-es felületet, ami kilistázza az adatbázisban szereplő összes kártyát, terméket amikhez két-két gomb-ot is társít.

Részletek gomb --> Itt tudjuk megtekinteni a különböző statisztikákat, mivel minden cselekvést egy külön táblába jegyzünk az adatbázisba így könnyedén tudunk statisztikát készíteni

Modósítás gomb --> Itt az adott termék vagy kártya adatait tudjuk modósítani.

## Telepítés
## Ubuntu 18.04-es laptop-ra
`sudo apt update`

`sudo apt install apache2`

`sudo ufw allow in "Apache Full"`

`sudo apt install mysql-server`

`sudo mysql_secure_installation`

`sudo apt install php libapache2-mod-php php-mysql`

**`sudo nano /etc/apache2/mods-enabled/dir.conf`**

`<IfModule mod_dir.c>
    DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>`


`sudo apt install postfix`

`sudo apt install mailutils`

`sudo service postfix restart`



`sudo systemctl restart apache2`


**web** mappába lévő fájlokat másoljuk az apache rootDirectory-ába alapértelmezetten: **/var/www/html**

### Az adatbázis kapcsolódáshoz való beállításokat a **config.ini** fájlban tudjuk modósítani.
### sql fájl futtatásához példa:
`mysql -u sama -p 1234567890 < sama.sql`

## ESP8266

**arduino_script** mappában lévő fájlokat pedig másoljuk fel az **ESP8266**-ra

### WiFi jelszó változtatásához az arduino script-et kell modósítani!
#### Alapértelmezett:
**SSID:** W1CA
**Jelszó:** N7XRvYdT
