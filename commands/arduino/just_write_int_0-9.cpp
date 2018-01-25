//g++ -o just_write_int_0-9 just_write_int_0-9.cpp
#include <iostream>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "SerialPort.h"

using namespace std;

//String for getting the output from arduino
char output[MAX_DATA_LENGTH];

/*Portname must contain these backslashes, and remember to
replace the following com port*/
char *port_name = "\\\\.\\COM6";

//String for incoming data
char incomingData[MAX_DATA_LENGTH];

int main()
{
  SerialPort arduino(port_name);
  if (arduino.isConnected()) cout << "Connection Established" << endl;
  else cout << "ERROR, check port name";

  while (arduino.isConnected())
  {
	cout << "Write something: \n";
    std::string input_string;
    //Getting input
    getline(cin, input_string);
	
	char *c_string = new char[1];// 3 ÝÒÎ ÄËÈÍÍÀ ÊÎÌÀÍÄÛ
	
	c_string[0] = input_string[0];
	printf("** comand = %c **\n",c_string[0]);
	
    //Writing string to arduino
    arduino.writeSerialPort(c_string, MAX_DATA_LENGTH);
	
    //freeing c_string memory
    delete[] c_string;
  }
}