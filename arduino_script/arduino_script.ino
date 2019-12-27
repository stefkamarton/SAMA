#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFiMulti.h>
#include <Wire.h>               // NFC library
#include <PN532_I2C.h>          // NFC library 
#include <PN532.h>              // NFC library
#include <NfcAdapter.h>         // NFC library

const char* ssid     = "W1CA";
const char* password = "N7XRvYdT";
const char* host = "10.42.0.1";  // IP serveur - Server IP
const int   port = 80;            // Port serveur - Server Port
const int   watchdog = 5000;        // Fréquence du watchdog - Watchdog frequency
unsigned long previousMillis = millis();

/*LEDS*/
const int LED_READY = 1;
const int LED_RED = 3;
const int LED_GREEN = 15;
const int LED_BLUE = 13;
const int LED_PAY = 16;

/*BUTTON*/
const int BUTTON = 12;
int counter = 0;
int cproduct = 0;

long currentTime = 0;
long startTime = 0;
String uid;
/*NFC*/
PN532_I2C pn532_i2c(Wire);
NfcAdapter nfc = NfcAdapter(pn532_i2c);

ESP8266WiFiMulti wifiMulti;
HTTPClient http;

void setup() {
  pinMode(BUTTON, INPUT_PULLUP);
  pinMode(LED_READY, OUTPUT);
  pinMode(LED_RED, OUTPUT);
  pinMode(LED_GREEN, OUTPUT);
  pinMode(LED_BLUE, OUTPUT);
  pinMode(LED_PAY, OUTPUT);
  digitalWrite(LED_READY, LOW);



  //Serial.begin(115200);
  delay(10);

  // We start by connecting to a WiFi network
  wifiMulti.addAP("W1CA", "N7XRvYdT");
  if (wifiMulti.run() == WL_CONNECTED) {
    digitalWrite(LED_READY, HIGH);
    delay(1000);
    digitalWrite(LED_READY, LOW);
  }
  delay(200);
  nfc.begin();
  digitalWrite(LED_READY, HIGH);
}

int value = 0;

void loop() {
  if (digitalRead(BUTTON) == HIGH)
  {
    currentTime = millis();
    if (startTime != 0 && currentTime - startTime > 5000) {
      digitalWrite(LED_PAY, HIGH);
      if (nfc.tagPresent())
      {
        if (wifiMulti.run() == WL_CONNECTED) {
          delay(500);
          digitalWrite(LED_READY, LOW);
          NfcTag tag = nfc.read();
          uid = tag.getUidString();
          uid.replace(" ", "");


          String url = "/pay?uid=";
          url += uid;
          url += "&product=";
          url += cproduct;

          http.begin(host, port, url);
          int httpCode = http.GET();
          if (httpCode) {
            if (httpCode == 200) {
              String payload = http.getString();
            }
          }
          http.end();
          delay(500);
          digitalWrite(LED_READY, HIGH);
          startTime = 0;
          cproduct = 0;
          counter = 0;
          digitalWrite(LED_RED, LOW);
          digitalWrite(LED_BLUE, LOW);
          digitalWrite(LED_GREEN, LOW);

        } else {
          digitalWrite(LED_PAY, LOW);
          delay(500);
          digitalWrite(LED_PAY, HIGH);
          delay(500);
          digitalWrite(LED_PAY, LOW);
          delay(500);
          digitalWrite(LED_PAY, HIGH);
          delay(500);
          digitalWrite(LED_PAY, LOW);
          delay(500);
          digitalWrite(LED_PAY, HIGH);
          delay(500);
        }
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
        cproduct = 0;
        break;
      case 1:
        digitalWrite(LED_BLUE, LOW);
        digitalWrite(LED_GREEN, HIGH);
        counter = 2;
        cproduct = 1;
        break;
      case 2:
        digitalWrite(LED_GREEN, LOW);
        digitalWrite(LED_RED, HIGH);
        counter = 0;
        cproduct = 2;
        break;
    }
    startTime = millis();
  }
  delay(100);
}
