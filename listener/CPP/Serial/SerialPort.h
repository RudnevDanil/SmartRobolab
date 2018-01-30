#ifndef SERIALPORT_H
#define SERIALPORT_H

#define ARDUINO_WAIT_TIME 2000
#define MAX_DATA_LENGTH 255

#include <windows.h>
#include <stdio.h>
#include <stdlib.h>

class SerialPort
{
private:
    HANDLE handler;
    bool connected;
    COMSTAT status;
    DWORD errors;
public:
    SerialPort(char *portName)
	{
		this->connected = false;

		this->handler = CreateFileA(static_cast<LPCSTR>(portName),
									GENERIC_READ | GENERIC_WRITE,
									0,
									NULL,
									OPEN_EXISTING,
									FILE_ATTRIBUTE_NORMAL,
									NULL);
		if (this->handler == INVALID_HANDLE_VALUE){
			if (GetLastError() == ERROR_FILE_NOT_FOUND){
				printf("ERROR: Handle was not attached. Reason: %s not available\n", portName);
			}
		else
			{
				printf("ERROR!!!");
			}
		}
		else {
			DCB dcbSerialParameters = {0};

			if (!GetCommState(this->handler, &dcbSerialParameters)) {
				printf("failed to get current serial parameters");
			}
			else {
				dcbSerialParameters.BaudRate = CBR_9600;
				dcbSerialParameters.ByteSize = 8;
				dcbSerialParameters.StopBits = ONESTOPBIT;
				dcbSerialParameters.Parity = NOPARITY;
				dcbSerialParameters.fDtrControl = DTR_CONTROL_ENABLE;

				if (!SetCommState(handler, &dcbSerialParameters))
				{
					printf("ALERT: could not set Serial port parameters\n");
				}
				else {
					this->connected = true;
					PurgeComm(this->handler, PURGE_RXCLEAR | PURGE_TXCLEAR);
					Sleep(ARDUINO_WAIT_TIME);
				}
			}
		}
	}
    ~SerialPort()
	{
		if (this->connected){
			this->connected = false;
			CloseHandle(this->handler);
		}
	}

    int readSerialPort(char *buffer, unsigned int buf_size)
	{
		DWORD bytesRead;
		unsigned int toRead;

		ClearCommError(this->handler, &this->errors, &this->status);

		if (this->status.cbInQue > 0){
			if (this->status.cbInQue > buf_size){
				toRead = buf_size;
			}
			else toRead = this->status.cbInQue;
		}

		if (ReadFile(this->handler, buffer, toRead, &bytesRead, NULL)) return bytesRead;

		return 0;
	}
    bool writeSerialPort(char *buffer, unsigned int buf_size)
	{
		DWORD bytesSend;

		if (!WriteFile(this->handler, (void*) buffer, buf_size, &bytesSend, 0)){
			ClearCommError(this->handler, &this->errors, &this->status);
			return false;
		}
		else return true;
	}
	bool writeSerialPort(int i)
	{
		unsigned int buf_size = 1;
		DWORD bytesSend;
		int i_copy = i;
		while(i_copy/10 > 0)
		{
			buf_size++;
			
		}
		char *buffer = new char[1];
		buffer[1] = i;

		if (!WriteFile(this->handler, (void*) buffer, buf_size, &bytesSend, 0)){
			ClearCommError(this->handler, &this->errors, &this->status);
			return false;
		}
		else return true;
	}	
    bool isConnected()
	{
		return this->connected;
	}
};

#endif // SERIALPORT_H