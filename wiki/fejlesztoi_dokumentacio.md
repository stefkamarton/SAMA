# Fejlesztői dokumentáció
## Telepítés
## Ubuntu 18.04-es laptop
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

### Termék LED-ek csatlakoztatása:
- Piros led: GPI03, GND
- Zöld led: GPI15, GND
- Kék led: GPI13, GND

### Állapot ledek csatlakoztatása:
- Piros led: GPI02, GND
- Kék led: GPI16, GND
- Narancssárga led: GPI01, GND

### Gomb: 
GND12, 3.3V, GND

### NFC olvasó: 
- GND -> GND
- VCC -> 3.3V
- SDA -> GPI04
- SCL -> GPI05


**arduino_script** mappában lévő fájlokat pedig másoljuk fel az **ESP8266**-ra

### WiFi jelszó változtatásához az arduino script-et kell modósítani!
#### Alapértelmezett:
**SSID:** W1CA
**Jelszó:** N7XRvYdT
