#include <iostream>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "SerialPort.h"

/*Portname must contain these backslashes, and remember to
replace the following com port*/
char *port_name = "\\\\.\\COM6";

//String for incoming data
char incomingData[MAX_DATA_LENGTH];

int main()
{
  SerialPort arduino(port_name);
  if (arduino.isConnected()) printf("Connection Established\n");
  else printf("ERROR, check port name");
  
  while (arduino.isConnected())
  {
    //Check if data has been read or not
    int read_result = arduino.readSerialPort(incomingData, MAX_DATA_LENGTH);
    //prints out data
    puts(incomingData);
    //wait a bit
    Sleep(10);
  }
}