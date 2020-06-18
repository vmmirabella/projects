package btp600.A2;

import java.util.Scanner;

public class Main {

    public static void main(String[] args) {
        Game game = null;
        String input;
        String playGame= "Crazy Eights";
        System.out.println("Games you can play:");
        System.out.println(playGame + "\n===========================");
        
        do {
            System.out.println("Choose a game to play:");
            Scanner keyboard = new Scanner(System.in);
            input = keyboard.nextLine();

            if (input.equalsIgnoreCase(playGame)) {
                game = new CrazyEightsGame();
                game.playGame();
            }
            else
                System.out.println("No game called " + input+" found. Try again");
        }while(!input.equalsIgnoreCase(playGame));
    }
}
