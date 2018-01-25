// g++ -o listener listener.cpp
#include <windows.h>
#include <iostream>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "Serial/SerialPort.h"

/*Portname must contain these backslashes, and remember to
replace the following com port*/
char *port_name_arduino = "\\\\.\\COM6";
char *port_name_rele = "\\\\.\\COM3";

SerialPort arduino(port_name_arduino);
//String for getting the output from arduino
char output[MAX_DATA_LENGTH];
//String for incoming data
char incomingData[MAX_DATA_LENGTH];

void puterror(char * str)
{
  fprintf(stderr, str);
  exit(1);
}

int rele_when_connect()
{
	FILE *status_file;
	status_file = fopen("status_file","w");
	if(status_file == NULL)
	{
		printf("I can't open status_file!");
		return 0;
	}
	char status[1];
	status[0]=0xff;
	fwrite(status, 1, 1, status_file);
	fclose(status_file);
	
	char first_bytes[1];
	first_bytes[0]=0x50;
	char second_bytes[1];
	second_bytes[0]=0x51;
	
	char init_bytes_1[1];
	init_bytes_1[0]=0x00;
	char init_bytes_2[1];
	init_bytes_2[0]=0xff;
 
    // Declare variables and structures
    HANDLE hSerial;
    DCB dcbSerialParams = {0};
    COMMTIMEOUTS timeouts = {0};   
    // Open the highest available serial port number
    fprintf(stderr, "Opening serial port...");
    hSerial = CreateFile(
                port_name_rele, GENERIC_READ|GENERIC_WRITE, 0, NULL,
                OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL );
    if (hSerial == INVALID_HANDLE_VALUE)
    {
            fprintf(stderr, "Error\n");
            return 1;
    }
    else fprintf(stderr, "OK\n");
    dcbSerialParams.DCBlength = sizeof(dcbSerialParams);
    if (GetCommState(hSerial, &dcbSerialParams) == 0)
    {
        fprintf(stderr, "Error getting device state\n");
        CloseHandle(hSerial);
        return 1;
    }
    dcbSerialParams.BaudRate = CBR_9600;
    dcbSerialParams.ByteSize = 8;
    dcbSerialParams.StopBits = ONESTOPBIT;
    dcbSerialParams.Parity = NOPARITY;
    if(SetCommState(hSerial, &dcbSerialParams) == 0)
    {
        fprintf(stderr, "Error setting device parameters\n");
        CloseHandle(hSerial);
        return 1;
    }
    // Set COM port timeout settings
    timeouts.ReadIntervalTimeout = 50;
    timeouts.ReadTotalTimeoutConstant = 50;
    timeouts.ReadTotalTimeoutMultiplier = 10;
    timeouts.WriteTotalTimeoutConstant = 50;
    timeouts.WriteTotalTimeoutMultiplier = 10;
    if(SetCommTimeouts(hSerial, &timeouts) == 0)
    {
        fprintf(stderr, "Error setting timeouts\n");
        CloseHandle(hSerial);
        return 1;
    }
    // Send specified text (remaining command line arguments)
    DWORD bytes_written, total_bytes_written = 0;
    fprintf(stderr, "Sending bytes...\n");
	//if(!WriteFile(hSerial, bytes_to_send, 5, &bytes_written, NULL))
    if(!WriteFile(hSerial, first_bytes, 1, &bytes_written, NULL))
    {
        fprintf(stderr, "Error\n");
        CloseHandle(hSerial);
        return 1;
    }  
	Sleep(100);//0.1 сек задержки
	if(!WriteFile(hSerial, second_bytes, 1, &bytes_written, NULL))
    {
        fprintf(stderr, "Error\n");
        CloseHandle(hSerial);
        return 1;
    }  
	Sleep(100);//0.1 сек задержки
	if(!WriteFile(hSerial, init_bytes_1, 1, &bytes_written, NULL))
    {
        fprintf(stderr, "Error\n");
        CloseHandle(hSerial);
        return 1;
    }  
	Sleep(100);//0.1 сек задержки
	if(!WriteFile(hSerial, init_bytes_2, 1, &bytes_written, NULL))
    {
        fprintf(stderr, "Error\n");
        CloseHandle(hSerial);
        return 1;
    } 
    // Close serial port
    fprintf(stderr, "Closing serial port...");
    if (CloseHandle(hSerial) == 0)
    {
        fprintf(stderr, "Error\n");
        return 1;
    }
    fprintf(stderr, "OK\n");	
    // exit normally
    return 0;
}

int arduino_move(bool right = true, bool move_20 = true)
{
    if (arduino.isConnected()) std::cout << "Connection Established" << std::endl;
    else 
	{
		std::cout << "ERROR, check port name";
		return 1;
	}		
	char *c_string = new char[1];
	c_string[0] = 1 + 48 + ((right)?1:0) + ((move_20)?2:0);		
	//Writing string to arduino
	arduino.writeSerialPort(c_string, MAX_DATA_LENGTH);		
	//freeing c_string memory
	delete[] c_string;
	return 0;
}

int arduino_move_left_5()
{
	return arduino_move(false,false);
}

int arduino_move_right_5()
{
	return arduino_move(true,false);
}

int arduino_move_left_20()
{
	return arduino_move(false,true);
}

int arduino_move_right_20()
{
	return arduino_move(true,true);
}

int switch_x(int nom_switch, int special_value = -1)
{
	unsigned char bytes_to_send[1];
	
	FILE *status_file_r;
	status_file_r = fopen("status_file","r+");
	if(status_file_r == NULL)
	{
		printf("I can't open status_file_r!");
		return 0;
	}
	unsigned char status;
	status = fgetc(status_file_r);
	printf("--%d--",status);
	fclose(status_file_r);
	
	if(special_value == -1)
	{
		bytes_to_send[0]=0;
		int changes = 1;
		for(int i = 1; i < nom_switch; ++i)
		{
			changes = changes * 2;
		}
		unsigned char byf_status = status >> (nom_switch - 1);
		if((byf_status % 2) == 0)
			bytes_to_send[0] = status + changes;
		else
			bytes_to_send[0] = status - changes;
	}
	else
		bytes_to_send[0]=special_value;
	
	printf("\nbytes_to_send[0]=%d\n",bytes_to_send[0]);
	
	FILE *status_file_w;
	status_file_w = fopen("status_file","w");
	if(status_file_w == NULL)
	{
		printf("I can't open status_file!");
		return 0;
	}
	fwrite(bytes_to_send, 1, 1, status_file_w);
	fclose(status_file_w);
	
    // Declare variables and structures
    HANDLE hSerial;
    DCB dcbSerialParams = {0};
    COMMTIMEOUTS timeouts = {0};
         
    // Open the highest available serial port number
    fprintf(stderr, "Opening serial port...");
    hSerial = CreateFile(
                port_name_rele, GENERIC_READ|GENERIC_WRITE, 0, NULL,
                OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL );
    if (hSerial == INVALID_HANDLE_VALUE)
    {
            fprintf(stderr, "Error\n");
            return 1;
    }
    else fprintf(stderr, "OK\n");
    dcbSerialParams.DCBlength = sizeof(dcbSerialParams);
    if (GetCommState(hSerial, &dcbSerialParams) == 0)
    {
        fprintf(stderr, "Error getting device state\n");
        CloseHandle(hSerial);
        return 1;
    }
     
    dcbSerialParams.BaudRate = CBR_9600;
    dcbSerialParams.ByteSize = 8;
    dcbSerialParams.StopBits = ONESTOPBIT;
    dcbSerialParams.Parity = NOPARITY;
    if(SetCommState(hSerial, &dcbSerialParams) == 0)
    {
        fprintf(stderr, "Error setting device parameters\n");
        CloseHandle(hSerial);
        return 1;
    }
 
    // Set COM port timeout settings
    timeouts.ReadIntervalTimeout = 50;
    timeouts.ReadTotalTimeoutConstant = 50;
    timeouts.ReadTotalTimeoutMultiplier = 10;
    timeouts.WriteTotalTimeoutConstant = 50;
    timeouts.WriteTotalTimeoutMultiplier = 10;
    if(SetCommTimeouts(hSerial, &timeouts) == 0)
    {
        fprintf(stderr, "Error setting timeouts\n");
        CloseHandle(hSerial);
        return 1;
    }
 
    // Send specified text (remaining command line arguments)
    DWORD bytes_written, total_bytes_written = 0;
    fprintf(stderr, "Sending bytes...");
	//-----------------
	if(!WriteFile(hSerial, bytes_to_send, 1, &bytes_written, NULL))
    {
        fprintf(stderr, "Error\n");
        CloseHandle(hSerial);
        return 1;
    }
    fprintf(stderr, "%d byte --%d-- has written\n", bytes_written,bytes_to_send[0]);
    //-----------------
    // Close serial port
    fprintf(stderr, "Closing serial port...");
    if (CloseHandle(hSerial) == 0)
    {
        fprintf(stderr, "Error\n");
        return 1;
    }
    fprintf(stderr, "OK\n");
    return 0;
}

int switch_1()
{
	switch_x(1);
	return 0;
}

int switch_2()
{
	switch_x(2);
	return 0;
}

int switch_3()
{
	switch_x(3);
	return 0;
}

int switch_4()
{
	switch_x(4);
	return 0;
}

int switch_5()
{
	switch_x(5);
	return 0;
}

int switch_6()
{
	switch_x(6);
	return 0;
}

int switch_7()
{
	switch_x(7);
	return 0;
}

int switch_8()
{
	switch_x(8);
	return 0;
}

int switch_all()
{
	unsigned char bytes_to_send[1];	
	std::cout << "switch_1 ..." << ((switch_1() == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_2 ..." << ((switch_2() == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_3 ..." << ((switch_3() == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_4 ..." << ((switch_4() == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_5 ..." << ((switch_5() == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_6 ..." << ((switch_6() == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_7 ..." << ((switch_7() == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_8 ..." << ((switch_8() == 0)?"SUCCESS\n":"FAILURE\n");
	printf("\nbytes_to_send[0]=%d\n",bytes_to_send[0]);

    fprintf(stderr, "OK\n");
	return 0;
}

int switch_all_off()
{
	switch_x(-1,255);
	return 0;
}

int switch_all_on()
{
	switch_x(-1,0);
	return 0;
}

int main()
{
	
	rele_when_connect();
	while(true)
	{
		std::cout << "---------------\nnom_but = ";
		int nom_but;
		std::cin >> nom_but;
		switch(nom_but)
		{
			case 1:  // YES CHECK
				std::cout << "switch_1 ..." << ((switch_1() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 2:  // YES CHECK
				std::cout << "switch_2 ..." << ((switch_2() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 3:  // YES CHECK
				std::cout << "switch_3 ..." << ((switch_3() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 4:  // YES CHECK
				std::cout << "switch_4 ..." << ((switch_4() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 5:  // YES CHECK
				std::cout << "switch_5 ..." << ((switch_5() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 6:  // YES CHECK
				std::cout << "switch_6 ..." << ((switch_6() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 7:  // YES CHECK
				std::cout << "switch_7 ..." << ((switch_7() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 8:  // YES CHECK
				std::cout << "switch_8 ..." << ((switch_8() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 9:  // YES CHECK
				std::cout << "switch_all ..." << ((switch_all() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 10:  // YES CHECK
				std::cout << "switch_all_off ..." << ((switch_all_off() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 11:  // YES CHECK
				std::cout << "switch_all_on ..." << ((switch_all_on() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 12:  // YES CHECK
				std::cout << "rele_when_connect ..." << ((rele_when_connect() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 13:  // YES CHECK
				std::cout << "arduino_move_left_5 ..." << ((arduino_move_left_5() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 14:  // YES CHECK
				std::cout << "arduino_move_right_5 ..." << ((arduino_move_right_5() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 15:  // YES CHECK
				std::cout << "arduino_move_left_20 ..." << ((arduino_move_left_20() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			case 16:  // YES CHECK
				std::cout << "arduino_move_right_20 ..." << ((arduino_move_right_20() == 0)?"SUCCESS\n":"FAILURE\n");    
				break;
			 default:  
				std::cout << "UNKNOWN COMMAND !!!\n";  
		}
	}	
    return 0;
}