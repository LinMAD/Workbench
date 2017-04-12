package main

import (
	"os"
	"flag"
	"log"
	"net"
	"bufio"
	"fmt"
)

func main()  {
	// Chat app mode
	var isHost bool

	flag.BoolVar(&isHost, "listen", false,"Listens on the specifyed IP adress.")
	flag.Parse()

	if isHost {
		// Read IP of host which must be listen
		// Example: -listen 127.0.0.1 8080
		if len(os.Args) <= 2 {
			log.Fatalln("Runtime error: listen flag provided but IP adress of host is empty.")
		}
		connIP := os.Args[2]
		// TODO Change port of host as third Arg
		runHost(connIP)
	} else {
		// Read IP of guest which will be connected to the host IP
		// Example: 190.150.150.1
		if len(os.Args) < 2 {
			log.Fatalln("Runtime error: guest IP adress not given.")
		}
		connIP := os.Args[1]
		runGuest(connIP)
	}
}

// Default host port of chats app
const port = "8080"

// RunHost is chat app mode like host to guest can connect for chat
func runHost(ip string) {
	hostIPnPort := ip + ":" + port
	log.Println("Chat runs as host and listening: ", hostIPnPort)

	// Start listen on TCP protocol the provided IP address on port
	listener, listenErr := net.Listen("tcp", hostIPnPort)
	if listenErr != nil {
		log.Fatalln("Runtime error: ", listenErr)
	}

	log.Println("Listening on: " + hostIPnPort)

	// Accept internal connection and listen
	acceptConn, acceptErr := listener.Accept()
	if acceptErr != nil {
		log.Fatalln("Runtime error: ", acceptErr)
	}

	// TODO add identification of new connection IP or name etc.
	log.Println("New connection accepted.")

	for {
		handelHostRuntime(acceptConn)
	}
}

// handelHostRuntime keeps session alive between host and guest
func handelHostRuntime(conn net.Conn)  {
	reader := bufio.NewReader(conn)
	incomeMessage, readErr := reader.ReadString('\n')
	if readErr != nil {
		log.Fatalln("Runtime error: ", readErr)
	}

	fmt.Println("Guest: ", incomeMessage)

	fmt.Print("You: ")
	replyReader := bufio.NewReader(os.Stdin)
	replyMessage, replyErr := replyReader.ReadString('\n')
	if replyErr != nil {
		log.Fatalln("Runtime error: ", replyErr)
	}

	fmt.Fprint(conn, replyMessage)
}

// RunGuest is chat app mode like guest to make chat session with host
func runGuest(ip string) {
	hostIPnPort := ip + ":" + port
	dailConn, dailErr := net.Dial("tcp", hostIPnPort)
	if dailErr != nil {
		log.Fatalln("Runtime error: ", dailErr)
	}

	for {
		handleGuestRuntime(dailConn)
	}
}

// handleGuestRuntime keeps session alive between guest and host
func handleGuestRuntime(conn net.Conn)  {
	fmt.Print("You: ")
	reader := bufio.NewReader(os.Stdin)
	incomeMessage, readErr := reader.ReadString('\n')
	if readErr != nil {
		log.Fatal("Error: ", readErr)
	}

	fmt.Fprint(conn, incomeMessage)

	replyReader := bufio.NewReader(conn)
	replyMessage, replyErr := replyReader.ReadString('\n')
	if replyErr != nil {
		log.Fatalln("Runtime error: ", replyErr)
	}

	fmt.Println("Host: ", replyMessage)
}