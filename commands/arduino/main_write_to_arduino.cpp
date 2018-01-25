//g++ -o main_write_to_arduino main_write_to_arduino.cpp
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
	//Getting reply from arduino
    arduino.readSerialPort(output, MAX_DATA_LENGTH);
	
    printf("** position = %c%c%c **\n",output[0],output[1],output[2]);
	
	/*    ÎÁÐÀÁÒÊÀ ÏÎÇÈÖÈÈ    */
	int pos = (output[0] -48)*100 + (output[1] -48)*10 + output[2]-48;
	printf("== %d ==\n",pos);
	
	//			ÄÓÌÀÞ ÊÎÑßÊ Â ÒÎÌ ×ÒÎ ÀÐÄÓÈÍÎ ÍÅÏÐÀÂÈËÜÍÎ ÎÁÐÀÁÀÒÛÂÀÅÒ ÃÄÅ ÒÎ +-48 ÏÎÄÅËÀÉ, ÎÒÑÞÄÀ ÓÕÎÄÈÒ ÊÀÊ ÍÀÄÎ
	
	char *c_string = new char[3 + 1];// 3 ÝÒÎ ÄËÈÍÍÀ ÊÎÌÀÍÄÛ
	
	//Adding the delimiter	
	c_string[2] = (pos % 10) + 48;
	pos /= 10;
	c_string[1] = (pos % 10) + 48;
	pos /= 10;
	c_string[0] = pos + 48;
	printf("** position ---= %c%c%c **\n",c_string[0],c_string[1],c_string[2]);
    c_string[3] = '\n';// äëèííà êîìàíäû + 1
	
    //Writing string to arduino
    arduino.writeSerialPort(c_string, MAX_DATA_LENGTH);
	
    //freeing c_string memory
    delete[] c_string;
  }
}