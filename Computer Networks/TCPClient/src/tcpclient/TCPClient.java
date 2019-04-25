/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tcpclient;
import java.util.Scanner;
import java.io.*;
import java.net.*;

/**
 *
 * @author N00150623
 */
public class TCPClient {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws Exception{
        // TODO code application logic here
        String sentence;
        String modifiedSentence;
        Scanner inFromUser = new Scanner(System.in);
        Socket clientSocket = new Socket("localhost", 6788);
        DataOutputStream outToServer = new DataOutputStream(clientSocket.getOutputStream());
        BufferedReader inFromServer = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
        System.out.println("Please enter a message to send to the server: ");
        sentence = inFromUser.nextLine();
        outToServer.writeBytes(sentence + '\n');
        modifiedSentence = inFromServer.readLine();
        System.out.println("FROM SERVER: " + modifiedSentence);
        clientSocket.close();
    }
    
}
