# Felhasználói dokumentáció
### Telepítés
**Ubuntu 18.04-es laptop-ra LAMP telepítés**:
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

`sudo systemctl restart apache2`


**web** mappába lévő fájlokat másoljuk az apache rootDirectory-ába alapértelmezetten: **/var/www/html**

**arduino_script** mappában lévő fájlokat pedig másoljuk fel az **ESP8266**-ra

## Web-es felület
**list.php** megnyitása böngészőbe.  **http://localhost/list.php**

![listphp](https://user-images.githubusercontent.com/44652322/71904776-0f852d00-3167-11ea-84e9-e12529be822e.PNG)
 ### Termékek
Hasonló felülettel fogunk találkozni mint a képen ahol az **első** táblázat a termékeket listázza ki, darabszámukkal, illetve árukkal együtt.
Minden sorhoz tartozik **két** gomb:

**Modósítás** -> Itt tudjuk modósítani az adott termékeket, **nevet, darabszámot, árat**

![termekmod](https://user-images.githubusercontent.com/44652322/71905048-a225cc00-3167-11ea-9a66-c50d30f63c03.PNG)


**Részletek** -> Itt láthatjuk a termékről készült statisztikákat. Jellemzően az **árról, darabszámokról**

![termekinfo](https://user-images.githubusercontent.com/44652322/71905117-c97c9900-3167-11ea-8360-9b1423d57893.PNG)

### Felhasználók
**Második** táblázat a regisztrált kártyákat listázza ki, **kártyaszámmal, névvel, e-mail-lel, egyenleggel és tranzakciók számával**
![listphp](https://user-images.githubusercontent.com/44652322/71904776-0f852d00-3167-11ea-84e9-e12529be822e.PNG)

Minden sorhoz tartozik **két** gomb:
**Modósítás** -> Itt tudjuk modósítani az adott bankártya adatait, **nevet, e-mail-t**, illetve egyenleget tudunk feltölteni.
![usermod](https://user-images.githubusercontent.com/44652322/71905582-bae2b180-3168-11ea-960e-a63c3e7a3f11.PNG)

**Részletek** -> Itt láthatjuk a bankártya használatról készült statisztikákat. Jellemzően az **vásárlásokról, feltöltésekről**
![userinfofull](https://user-images.githubusercontent.com/44652322/71905731-09904b80-3169-11ea-93a9-f1ce9992fe08.png)

## ESP8266