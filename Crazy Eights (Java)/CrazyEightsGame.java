package btp600.A2;

import java.util.Scanner;

/**
 * Created by VM on 4/2/2016.
 */
public class CrazyEightsGame extends Game{

    /*Constructor that initializes data members in game, players, deck and pile (set to null in game) through super()
    * Constructor than initialises pile since Crazy Eights uses the pile class. Finally it calls uses the FactoryProducer
    * to create the CrazyEights factory by passing in the string "Crazy Eights" to make sure that CrazyEightsGame contains
    * a CrazyEightsFactory (which has objects needed to play crazy eights).
    */
    public CrazyEightsGame()
    {
        super();
        pile=new Pile();
        cardGame = FactoryProducer.getFactory("Crazy Eights");
    }

   /*Creates and sets the opening game up. Calls the initializeGame method from Game which creates the Rules, deck and sets the proper scoring
   * strategy that will be used in Crazy Eights. This method will ask the user how many players they are playing with and how many of those players are
   * computer players. This method will then set-up both the computer and human players with opening hands. This method also determines the opening Pile card
   */
    public void initializeGame(){
        super.initializeGame();

        String [] computer_names = {"Bob", "Jessica","James", "Stephanie","Albert", "Elan", "Jackson" };
        int nameCounter=0;

        int numPlayers=0, numComps=9, numHum;
        Scanner keyboard;
        String input;

        do {
            System.out.println("How many players are playing? (2,3,4..8)");
            keyboard = new Scanner(System.in);
            input = keyboard.nextLine();
            numPlayers = Integer.parseInt(input);
        }while(numPlayers>8 || numPlayers<2);

        do {
            System.out.println("Number of computer players?");
            keyboard = new Scanner(System.in);
            input = keyboard.nextLine();
            numComps = Integer.parseInt(input);
        }while(numComps>(numPlayers-1));

        numHum = numPlayers - numComps;

        //create human/computer players
        for(int i=0; i<numPlayers; i++)
        {
            if(numHum>i) {
                System.out.println("Name for human player " + (i+1));
                keyboard = new Scanner(System.in);
                input = keyboard.nextLine();
                players.add((cardGame.makeHuman(input)));
            }
            else
                players.add(cardGame.makeComputer("Computer_"+ computer_names[nameCounter++]));
        }

        //deal cards to all palyers
        int cardsToDeal=5;
        for (Player player : players) {
            for (int i = 0; i < cardsToDeal; i++)
                player.drawCard(deck);

            player.sortHand();
        }

        //flip first card
        boolean checkfor8;

        do{
            Card cardCheck= deck.drawCard();
            checkfor8 = cardCheck.getRank()==8;

            if(checkfor8){
                deck.insertCard(cardCheck);
                deck.shuffle();
            }
            else {
                pile.getCards().add(cardCheck);

            }
        }while(checkfor8);

        System.out.println("---------Instructions----------");
        System.out.println("To play a card you must match the rank or suit of the card atop the pile OR you have an 8 in your hand (if you play an 8 you must choose the suit.\n" +
                "EX:If you wish to play 3DIAMONDS from your hand you may type 3d or 3diamonds. \n" + "If a player is unable to make a play you will be drawn up to 3 cards.\n" +
                "If a play is still unable to be made after 3 cards have been drawn then that player's turn is passed\n"+
                "A game ends when a player has no cards in hand OR neither player can make a play and the deck is empty.");
    }

    /*Calls the super player turn method passing the player in as a parameter to have them take their turn.
    */
    public void playerTurn(Player player){ super.playerTurn(player);}

    /*No parameters, only return type. This method will return false if the game is still currently going and return true
    *if the game has finished (in the case of crazy eights that is if a player has an emptyhand or no one is able to play a card and the deck is empty).
    * If the game is over this method will determine the winner based on scoring.
    * */
    public boolean gameOver() {
        boolean over=false;
        int counter, lostTurn=0;

        for(int i=0; i<players.size(); i++)
        {
            if(players.get(i).hasEmptyHand())
            {
                scoringStrat.calScore(players);
                over=true;
                break;
            }
            else if(deck.isEmpty())
            {
                counter=0;
                for(int j=0; j<players.get(i).hand.getNumCards(); j++) {
                    if (ruleSet.isValid(players.get(i).hand.getCard(j), pile.topOfPile()))
                        break;
                    else
                        counter++;
                }
                if (counter == players.get(i).hand.getNumCards())
                    lostTurn++;
            }
        }

        if (deck.isEmpty() && players.size() == lostTurn)//no player is able to make a turn or draw cards
            over=true;

        if(over)
        {
           Player temp= players.get(0);
            int winner = 0;
            System.out.println("\n\nScoring:");
            System.out.println(players.get(0).getName() +" scored " + players.get(0).getPoints());

            for (int i =1; i<players.size(); i++){
                System.out.println(players.get(i).getName() +" scored " + players.get(i).getPoints());
                if(!(temp.getPoints() > players.get(i).getPoints()))
                {
                    temp = players.get(i);
                    winner=i;
                }

            }//end of for
            System.out.println("And the winner is...." + players.get(winner).getName()+ "!!");
        }

        return over;
    }
}
