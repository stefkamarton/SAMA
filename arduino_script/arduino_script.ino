#include <ESP8266WiFi.h>        // Wifi library
#include <Wire.h>               // NFC library
#include <PN532_I2C.h>          // NFC library 
#include <PN532.h>              // NFC library
#include <NfcAdapter.h>         // NFC library


/*WIFI SETTINGS*/
const char* ssid     = "STEFKA_NET";
const char* password = "Pepsi1234";

/*LEDS*/
const int LED_READY = 1;
const int LED_RED = 3;
const int LED_GREEN = 15;
const int LED_BLUE = 13;
const int LED_PAY = 16;

/*BUTTON*/
const int BUTTON = 12;
int counter = 0;

long currentTime = 0;
long startTime = 0;

/*NFC*/
PN532_I2C pn532_i2c(Wire);
NfcAdapter nfc = NfcAdapter(pn532_i2c);

void setup(void) {
  pinMode(BUTTON, INPUT_PULLUP);
  pinMode(LED_READY, OUTPUT);
  pinMode(LED_RED, OUTPUT);
  pinMode(LED_GREEN, OUTPUT);
  pinMode(LED_BLUE, OUTPUT);
  pinMode(LED_PAY, OUTPUT);

  digitalWrite(LED_READY, LOW);
  /* WIFI CONNECTION */
  //                Serial.begin(9600);
  WiFi.begin(ssid, password);             // Connect to the network
  //Serial.print("Connecting to ");
  //Serial.print(ssid); Serial.println(" ...");

  int i = 0;
  while (WiFi.status() != WL_CONNECTED) { // Wait for the Wi-Fi to connect
    delay(1000);
    //Serial.print(++i); Serial.print(' ');
  }
  //Serial.println('\n');
  //Serial.println("Connection established!");
  //Serial.print("IP address:\t");
  //Serial.println(WiFi.localIP()); /* ESP8266 ip address*/

  /*NFC*/
  //Serial.println("NDEF Reader");
  nfc.begin();
  digitalWrite(LED_READY, HIGH);

}

void loop(void) {

  /*NFC*/
  //Serial.println("\nScan a NFC tag\n");
  /* if (nfc.tagPresent())
    {
     digitalWrite(LED_READY,LOW);
     NfcTag tag = nfc.read();
     //Serial.println(tag.getTagType());
     //Serial.print("UID: ");Serial.println(tag.getUidString()); // Retrieves the Unique Identification from your tag
     delay(500);
     digitalWrite(LED_READY,HIGH);
     delay(500);
    }*/
  if (digitalRead(BUTTON) == HIGH)
  {
    currentTime = millis();
    if (startTime != 0 && currentTime - startTime > 5000) {
      digitalWrite(LED_PAY, HIGH);
      if (nfc.tagPresent())
      {
        delay(500);
        digitalWrite(LED_READY, LOW);
        NfcTag tag = nfc.read();
        delay(500);
        digitalWrite(LED_READY, HIGH);
        startTime = 0;
      } else {
        startTime = millis();
      }
      digitalWrite(LED_PAY, LOW);
    }
  } else {
    switch (counter) {
      case 0:
        digitalWrite(LED_RED, LOW);
        digitalWrite(LED_BLUE, HIGH);
        counter = 1;
        break;
      case 1:
        digitalWrite(LED_BLUE, LOW);
        digitalWrite(LED_GREEN, HIGH);
        counter = 2;
        break;
      case 2:
        digitalWrite(LED_GREEN, LOW);
        digitalWrite(LED_RED, HIGH);
        counter = 0;
        break;
    }
    startTime = millis();
  }
  delay(100);
}