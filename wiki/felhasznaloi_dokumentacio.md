# Felhasználói dokumentáció
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

### Ha esetlegesen még nem áll rendelkezésre annyi adat hogy statisztika készülhessen belöle akkor ez az üzenet fog minket fogadni.
![jelenlegnemkeszithetostatisztika](https://user-images.githubusercontent.com/44652322/71906527-87a12200-316a-11ea-82d4-8dfc51fd9965.PNG)


## ESP8266
**Kék, zöld, piros** ledekből álló csoport az automatából kiválasztható 3 különböző italt jelöli.
![termekledek](https://user-images.githubusercontent.com/44652322/71907085-9805cc80-316b-11ea-98c5-64131fba9aca.jpg)

A termékek között egy ezzel rendszeresített **gomb**bal tudunk váltani.
![82272736_2569656716635812_5995598599449214976_n](https://user-images.githubusercontent.com/44652322/71907388-342fd380-316c-11ea-8248-82ce4a68af96.jpg)

**Piros, kék, narancssárga** ledekből álló csoport a funkcionalitásokat és visszajelzéseket hivatott jelölni.
![81536108_461948101168729_1548220149817933824_n](https://user-images.githubusercontent.com/44652322/71907497-748f5180-316c-11ea-8551-7d6e16623db5.jpg)

#### Narancssárga led
Alaphelyzetben a narancssárga led folyamatosan világít, a többi nem, ez jelzi a készenléti állapotot. 
**2 hosszú** villanás - Kártya regisztrálása a rendszerbe

### Piros led
**1 hosszú, 1 rövid, 1 hosszú** villanás - Nincs elegendő pénz a kártyádon
**2 hosszú** villanás - Nincs a raktáron a kiválasztott űdítőből
**4 rövid** villanás - Nincs WiFi kapcsolat 

### Kék led
**Folyamatosan** világít - Fizetésre kész állapotban van

##Sikeres fizetéskor
**Narancssárga** villanik egyet, a kék led pedig elalszik.

## Vásárlás
Amikor folyamatosan világít a sárga led, a gombbal kitudjuk választani az űdítőt.
Miután kiválasztottuk a megfelelő terméket várjunk addig amíg a **kék led folyamatosan** nem kezd el világítani, 
ha 10 másodpercen belül nem fizetünk akkor a rendszer elveszi a fizetéstől való jogot (**elalszik a kék led**) és ilyenkor tudunk modósítani a kiválasztott űdítőn.
Fizetés esetén pedig a ledek jelzik vissza a ledek sikerességét/sikertelenségét.
