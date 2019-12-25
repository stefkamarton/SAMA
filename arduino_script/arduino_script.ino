#include <ESP8266WiFi.h>        // Include the Wi-Fi library
#include <Wire.h>
#include <PN532_I2C.h>
#include <PN532.h>
#include <NfcAdapter.h>

const char* ssid     = "STEFKA_NET";
const char* password = "Pepsi1234"; 
const int LED=3;

PN532_I2C pn532_i2c(Wire);
NfcAdapter nfc = NfcAdapter(pn532_i2c);

void setup(void) {
  /* WIFI CONNECTION */
    Serial.begin(9600);
WiFi.begin(ssid, password);             // Connect to the network
  Serial.print("Connecting to ");
  Serial.print(ssid); Serial.println(" ...");

  int i = 0;
  while (WiFi.status() != WL_CONNECTED) { // Wait for the Wi-Fi to connect
    delay(1000);
    Serial.print(++i); Serial.print(' ');
  }

  Serial.println('\n');
  Serial.println("Connection established!");  
  Serial.print("IP address:\t");
  Serial.println(WiFi.localIP());         // Send the IP address of the ESP8266 to the computer
/*NFC*/    
    Serial.println("NDEF Reader");
    nfc.begin();
    pinMode(LED,OUTPUT);
}

void loop(void) {


  /*NFC*/
  Serial.println("\nScan a NFC tag\n");
    if (nfc.tagPresent())
    {
          Serial.println("Belép");
            digitalWrite(LED,HIGH);

          NfcTag tag = nfc.read();
          Serial.println(tag.getTagType());
          Serial.print("UID: ");Serial.println(tag.getUidString()); // Retrieves the Unique Identification from your tag
          delay(500);
          digitalWrite(LED,LOW);

    }
    delay(1000);
}

/*
const int LED=3;
void setup() {
  // put your setup code here, to run once:
pinMode(LED,OUTPUT);
}

void loop() {
  delay(1000);
  digitalWrite(LED,HIGH);
delay(1000);
  digitalWrite(LED,LOW);
}*/
