// gcc -o arduino_right_5 arduino_right_5.cpp
#include <windows.h>
#include <stdio.h>

int main()
{
	unsigned char bytes_to_send[4];
	FILE *status_file_r;
	status_file_r = fopen("status_file","r+");
	if(status_file_r == NULL)
	{
		printf("+++I can't open status_file_r!");
		return 0;
	}
	unsigned char status[4];
	for(int i = 0; i < 4; ++i)
	{
		status[i] = fgetc(status_file_r);
		printf("--%d--",status[i]);
	}
	fclose(status_file_r);
	
	bytes_to_send[0]='1';
	if((bytes_to_send[1] == '0')&&(bytes_to_send[2] == '0')&&(bytes_to_send[3] < '5')) 
		bytes_to_send[3] = '5';
	
	bytes_to_send[3] -= 5;
	
	
	printf("\nuse %d%d%d\n",bytes_to_send[1],bytes_to_send[2],bytes_to_send[3]);
	
	FILE *status_file_w;
	status_file_w = fopen("status_file","w");
	if(status_file_w == NULL)
	{
		printf("---I can't open status_file!");
		return 0;
	}
	fwrite(bytes_to_send, 2, 3, status_file_w);
	fclose(status_file_w);
	
    // Declare variables and structures
    HANDLE hSerial;
    DCB dcbSerialParams = {0};
    COMMTIMEOUTS timeouts = {0};
         
    // Open the highest available serial port number
    fprintf(stderr, "Opening serial port...");
    hSerial = CreateFile(
                "\\\\.\\COM6", GENERIC_READ|GENERIC_WRITE, 0, NULL,
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
	if(!WriteFile(hSerial, bytes_to_send, 4, &bytes_written, NULL))
    {
        fprintf(stderr, "Error\n");
        CloseHandle(hSerial);
        return 1;
    }
    fprintf(stderr, "%d byte --%d-- has written\n", bytes_written,bytes_to_send[0]);
    //-----------------
	//Sleep(1000);//1 сек задержки
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