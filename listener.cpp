// g++ -o listener listener.cpp
#include <windows.h>
#include <unistd.h>
#include <iostream>
#include <stdio.h>
#include <stdlib.h>
#include <string>

#ifndef SERIALPORT_H
#define SERIALPORT_H

#define ARDUINO_WAIT_TIME 2000
#define MAX_DATA_LENGTH 1

#include <windows.h>
#include <stdio.h>
#include <stdlib.h>

class SerialPort
{
private:
    HANDLE handler;
    COMSTAT status;
    DWORD errors;
	
public : 
	bool connected;
	
	//SerialPort(){printf(" === Serial === CONSTRUCTOR() === \n");}

	void initialize(char *portName)
	{
		//printf(" === Serial === initialize(portName) === \n");
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
		else 
		{
			DCB dcbSerialParameters = {0};

			if (!GetCommState(this->handler, &dcbSerialParameters)) 
			{
				printf("failed to get current serial parameters");
			}
			else 
			{
				dcbSerialParameters.BaudRate = CBR_9600;
				dcbSerialParameters.ByteSize = 8;
				dcbSerialParameters.StopBits = ONESTOPBIT;
				dcbSerialParameters.Parity = NOPARITY;
				dcbSerialParameters.fDtrControl = DTR_CONTROL_ENABLE;

				if (!SetCommState(handler, &dcbSerialParameters))
				{
					printf("ALERT: could not set Serial port parameters\n");
				}
				else 
				{
					this->connected = true;
					PurgeComm(this->handler, PURGE_RXCLEAR | PURGE_TXCLEAR);
					Sleep(ARDUINO_WAIT_TIME);
				}
			}
		}
	}
	
    ~SerialPort()
	{
		//printf(" === Serial === DESTRUCTOR === \n");
		if (this->connected){
			this->connected = false;
			CloseHandle(this->handler);
		}
	}
	bool writeSerialPort(char *buffer, unsigned int buf_size)
	{
		//printf(" === Serial === writeSerialPort === \n");
		DWORD bytesSend;

		if (!WriteFile(this->handler, (void*) buffer, buf_size, &bytesSend, 0))
		{
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

// initialization
char *port_name_arduino;
char *port_name_rele;
int amount_of_readed_records = 0;
SerialPort arduino;

//function for connectiont to relay
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
    //fprintf(stderr, "Realy connection...");
    hSerial = CreateFile(
                port_name_rele, GENERIC_READ|GENERIC_WRITE, 0, NULL,
                OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL );
    if (hSerial == INVALID_HANDLE_VALUE)
    {
            fprintf(stderr, "Error\n");
            return 1;
    }
    //else fprintf(stderr, "OK\n");
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
    //fprintf(stderr, "Sending bytes...\n");
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
    //fprintf(stderr, "Closing serial port...");
    if (CloseHandle(hSerial) == 0)
    {
        fprintf(stderr, "Error\n");
        return 1;
    }
    //fprintf(stderr, "OK\n");	
    // exit normally
    return 0;
}

//function for write char to arduino
int arduino_write(char command)
{
    if (arduino.isConnected()) std::cout << "Connection Established" << std::endl;
    else 
	{
		std::cout << "ERROR, check port name";
		return 1;
	}		
	char *c_string = new char[1];
	c_string[0] = command;		
	//Writing string to arduino
	arduino.writeSerialPort(c_string, MAX_DATA_LENGTH);		
	//freeing c_string memory
	delete[] c_string;
	return 0;
}

//function for switch relay ( write to relay )
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

//function for switch all 8 relay
int switch_all()
{
	unsigned char bytes_to_send[1];	
	std::cout << "switch_1 ..." << ((switch_x(1) == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_2 ..." << ((switch_x(2) == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_3 ..." << ((switch_x(3) == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_4 ..." << ((switch_x(4) == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_5 ..." << ((switch_x(5) == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_6 ..." << ((switch_x(6) == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_7 ..." << ((switch_x(7) == 0)?"SUCCESS\n":"FAILURE\n");
	std::cout << "switch_8 ..." << ((switch_x(8) == 0)?"SUCCESS\n":"FAILURE\n");
	printf("\nbytes_to_send[0]=%d\n",bytes_to_send[0]);

    fprintf(stderr, "OK\n");
	return 0;
}

//function for finding last unreaded command in the file
int find_last_unreaded_command(std::string file_name)
{
    int byf = 0;
    
    FILE *mf;
    do
    {
        mf=fopen (("C:\\smartrobalab_data\\" + file_name).c_str(),"r+");
    }while(mf == NULL);
    
    fseek(mf,0,SEEK_END);
	char str[13];
    if(ftell(mf) > amount_of_readed_records * 3)
    {
        fseek (mf, amount_of_readed_records * 3,SEEK_SET);
        
        if (fgets (str, sizeof (str), mf)==NULL)
           printf ("ERROR of getting string\n");
        else
        {
            byf = ((int)str[0]-48)*10+((int)str[1]-48);
        }     
        
    }    
	if ( fclose (mf) == EOF) printf ("CLOSING ERROR\n");
    return byf;
}

//function for check file in directory
int is_file_exist(std::string file_name)
{
	int byf;
	FILE *mf;
	mf=fopen (("C:\\smartrobalab_data\\" + file_name).c_str(),"r+");
	if(mf == NULL)
		byf = 0;
	else
		byf = 1;
	fclose(mf);
	return byf;
}

//function for downloading commands file
void download(std::string file_name,std::string login,std::string password)
{
	system(("IF EXIST C:\\smartrobalab_data\\" + file_name + " (del C:\\smartrobalab_data\\" + file_name + ")").c_str());
	system("IF EXIST C:\\smartrobalab_data\\wrong_login_or_password.txt (del C:\\smartrobalab_data\\wrong_login_or_password.txt)");		
	int max_wait_before_try = 6, wait = max_wait_before_try;
	while((is_file_exist(file_name) == 0)&&(is_file_exist("wrong_login_or_password.txt") == 0))
	{
		if(++wait > max_wait_before_try)
		{
			//std::cout << ((" start browser \"http://h96046yr.beget.tech/download.php?login="+login+"&pass="+password+"\"").c_str()) << std::endl;
			system(("start browser \"http://h96046yr.beget.tech/download.php?login="+login+"&pass="+password+"\"").c_str());
			wait = 0;
		}
		else
		{
			//std::cout << " wait browser ..." << std::endl;
			sleep(1);
		}
	}
}

//function for log in
int try_to_log(std::string login,std::string password)
{
	std::cout << " try to log...\n";
	system("IF EXIST C:\\smartrobalab_data\\wrong_login_or_password.txt (del C:\\smartrobalab_data\\wrong_login_or_password.txt)");
	download(login+"_commands.txt",login,password);
	if(is_file_exist("wrong_login_or_password.txt"))
	{
		system("IF EXIST C:\\smartrobalab_data\\wrong_login_or_password.txt (del C:\\smartrobalab_data\\wrong_login_or_password.txt)");
		std::cout<<" ... log is FAILED" << std::endl;
		return 0;
	}
	std::cout<<" ... log is OK" << std::endl;
	return 1;
}

int main()
{	
	// connect to relay
	int rele_port_int, is_rele_connected = 0;
	while(!is_rele_connected)
	{
		std::cout << "Which com port use for relay?	1..99	";
		rele_port_int = 100;
		while(rele_port_int >= 100 || rele_port_int < 0)
		{
			std::cin >> rele_port_int;
		}	
		if(rele_port_int < 10)
		{
			port_name_rele =(char *) calloc(9,1);
		}
		else
		{
			port_name_rele =(char *) calloc(11,1);
		}
		port_name_rele[0] = port_name_rele[1] = port_name_rele[3] = '\\';
		port_name_rele[2] = '.';
		port_name_rele[4] = 'C'; port_name_rele[5] = 'O'; port_name_rele[6] = 'M';
		if(rele_port_int < 10)
		{
			port_name_rele[7] = rele_port_int + 48;
		}
		else
		{
			port_name_rele[7] = (int)(rele_port_int*1.0/10) + 48;
			port_name_rele[8] = (rele_port_int % 10) + 48;
		}
		
		std::cout << "relay port is " <<  port_name_rele << std::endl;
		if(rele_when_connect())
		{
			std::cout << "=== ERROR!!! Do you want try one more time with different port? y/n	";
			char answer;
			std::cin >> answer;
			is_rele_connected = (answer == 'y')?0:1;
		}
		else
		{
			is_rele_connected = 1;
		}
	}
	
	// connect to arduino
	std::cout << std::endl;
	int arduino_port_int, is_arduino_connected = 0;
	while(!is_arduino_connected)
	{
		std::cout << "Which com port use for arduino?	1..99	" << std::endl;
		arduino_port_int = 100;
		while(arduino_port_int >=100 || arduino_port_int < 0)
		{
			std::cin >> arduino_port_int;
		}	
		if(arduino_port_int < 10)
		{
			port_name_arduino =(char *) calloc(9,1);
		}
		else
		{
			port_name_arduino =(char *) calloc(11,1);
		}
		port_name_arduino[0] = port_name_arduino[1] = port_name_arduino[3] = '\\';
		port_name_arduino[2] = '.';
		port_name_arduino[4] = 'C'; port_name_arduino[5] = 'O'; port_name_arduino[6] = 'M';
		if(arduino_port_int < 10)
		{
			port_name_arduino[7] = arduino_port_int + 48;
		}
		else
		{
			port_name_arduino[7] = (int)(arduino_port_int*1.0/10) + 48;
			port_name_arduino[8] = (arduino_port_int % 10) + 48;
		}
		
		std::cout << "arduino port is " <<  port_name_arduino << std::endl;
		arduino.~SerialPort();
		arduino.initialize(port_name_arduino);
		if(!arduino.isConnected())
		{
			std::cout << "=== ERROR!!! Do you want try one more time with different port? y/n	";
			char answer;
			std::cin >> answer;
			is_arduino_connected = (answer == 'y')?0:1;
		}
		else
		{
			is_arduino_connected = 1;
		}
	}	
	
	// log in
	std::string login = "", password = "";
	int is_logged = 0;
	while(!is_logged)
	{
		std::cout << "Enter login: ";
		std::cin >> login;
		std::cout << "Enter password: ";
		std::cin >> password;
		is_logged = (try_to_log(login,password)?1:0);
		if(!is_logged)
			std::cout << "\n\n Wrong login or password! Please, try again...\n\n";
	}	
	std::cout << "\n\n You are successfully authorized!\n\n";
	std::cout << " first open browser... " << std::endl;
	system("start browser \"http://h96046yr.beget.tech/about_project.php");
	sleep(1);
	
	// claen the data directory
	system("IF EXIST C:\\smartrobalab_data (rmdir /S/Q C:\\smartrobalab_data)");
	system("mkdir C:\\smartrobalab_data");
	download(login + "_commands.txt",login,password);
	
	// life
	while(true)
	{
        std::cout << std::endl << "*********************************************" << std::endl << std::endl;
		int last_unreaded_command = find_last_unreaded_command(login + "_commands.txt");
        if(last_unreaded_command == 0)
        {
			std::cout << " ---------------- NOTHING NEW ----------------" <<std::endl;
			download(login + "_commands.txt",login,password);
        }            
        else
        {
            ++amount_of_readed_records;
			std::cout << " command  " << last_unreaded_command << std::endl;
            switch(last_unreaded_command)
            {
				//-------------------------- MAIN SWITCHER ---------------------------------------
                case 1:   
                    std::cout << "switch_1 ..." << ((switch_x(1) == 0)?"SUCCESS\n":"FAILURE\n"); 
                    break;
                case 2:   
                    std::cout << "switch_2 ..." << ((switch_x(2) == 0)?"SUCCESS\n":"FAILURE\n");   
                    break;
                case 3:   
                    std::cout << "switch_3 ..." << ((switch_x(3) == 0)?"SUCCESS\n":"FAILURE\n");   
                    break;
                case 4:   
                    std::cout << "switch_4 ..." << ((switch_x(4) == 0)?"SUCCESS\n":"FAILURE\n");   
                    break;
                case 5:   
                    std::cout << "switch_5 ..." << ((switch_x(5) == 0)?"SUCCESS\n":"FAILURE\n");   
                    break;
                case 6:   
                    std::cout << "switch_6 ..." << ((switch_x(6) == 0)?"SUCCESS\n":"FAILURE\n");   
                    break;
                case 7:   
                    std::cout << "switch_7 ..." << ((switch_x(7) == 0)?"SUCCESS\n":"FAILURE\n");   
                    break;
                case 8:   
                    std::cout << "switch_8 ..." << ((switch_x(8) == 0)?"SUCCESS\n":"FAILURE\n");   
                    break;
                case 9:   
                    std::cout << "switch_all ..." << ((switch_all() == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
                case 10:   
                    std::cout << "switch_all_off ..." << ((switch_x(-1,255) == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
                case 11:   
                    std::cout << "switch_all_on ..." << ((switch_x(-1,0) == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
                case 12:   
                    std::cout << "rele_when_connect ..." << ((rele_when_connect() == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
					//--------------------------- CAMERA ---------------------------------------------------------
                case 13:   
                    std::cout << "arduino_write(w) ..." << ((arduino_write('w') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
                case 14:   
                    std::cout << "arduino_write(e) ..." << ((arduino_write('e') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
                case 15:   
                    std::cout << "arduino_write(q) ..." << ((arduino_write('q') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
                case 16:   
                    std::cout << "arduino_write(r) ..." << ((arduino_write('r') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
					//------------------------------ ARDUINO SWITCHER -------------------------------------------------
				case 18:   
					std::cout <<  arduino.isConnected() << std::endl;
                    std::cout << "arduino_write(1) ..." << ((arduino_write('1') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 19:   
                    std::cout << "arduino_write(2) ..." << ((arduino_write('2') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 20:   
                    std::cout << "arduino_write(3) ..." << ((arduino_write('3') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 21:   
                    std::cout << "arduino_write(4) ..." << ((arduino_write('4') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 22:   
                    std::cout << "arduino_write(5) ..." << ((arduino_write('5') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 23:   
                    std::cout << "arduino_write(6) ..." << ((arduino_write('6') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 24:   
                    std::cout << "arduino_write(7) ..." << ((arduino_write('7') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 25:   
                    std::cout << "arduino_write(8) ..." << ((arduino_write('8') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 26:   
                    std::cout << "arduino_write(all off) ..." << ((arduino_write('f') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 27:   
                    std::cout << "arduino_write(all on) ..." << ((arduino_write('n') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
				case 28:   
                    std::cout << "arduino_write(switch all) ..." << ((arduino_write('s') == 0)?"SUCCESS\n":"FAILURE\n");    
                    break;
                 default:  
                    std::cout << "UNKNOWN COMMAND !!!\n";  
            }
        }
		std::cout << std::endl << "*********************************************" << std::endl;
	}
    return 0;
}