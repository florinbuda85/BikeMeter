#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#define USE_SERIAL Serial

ESP8266WiFiMulti WiFiMulti;

const int buttonPin = D8;
const int ledPin =  LED_BUILTIN;      

int buttonState = 0; 
int previousState = 0;


void setup() {
  // initialize the LED pin as an output:
  pinMode(ledPin, OUTPUT);
  // initialize the pushbutton pin as an input:
  pinMode(buttonPin, INPUT);

  USE_SERIAL.begin(115200);
  USE_SERIAL.println();
  USE_SERIAL.println();
  USE_SERIAL.println();

  for (uint8_t t = 4; t > 0; t--) {
    USE_SERIAL.printf("[SETUP] WAIT %d...\n", t);
    USE_SERIAL.flush();
    delay(1000);
  }

  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("Skynet", "xxx");
}

void loop() {

  buttonState = digitalRead(buttonPin);

  if (buttonState != previousState) {
      previousState = buttonState;
     
      if (buttonState == HIGH) {
          digitalWrite(ledPin, HIGH);
          if ((WiFiMulti.run() == WL_CONNECTED)) {
              HTTPClient http;
              http.begin("http://192.168.0.178/bikeLog/insert.php"); //HTTP
              USE_SERIAL.print("[HTTP] GET...\n");
              int httpCode = http.GET();
              http.end();
          }
      } else {
          digitalWrite(ledPin, LOW);
      } 
  }
}
