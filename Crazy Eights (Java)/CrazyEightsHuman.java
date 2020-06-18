package btp600.A2;

import java.util.Scanner;

/**
 * Created by VM on 4/11/2016.
 */
public class CrazyEightsHuman extends CrazyEightsPlayer{

    //method that calls the super constructor to assign the player's name, which is passed in as a parameter
    public CrazyEightsHuman(String name) {
        super(name);
    }

    /*This method takes in Rules, Deck and Pile as parameters. This method will return true to signal it has completed this player's turn.
    *Calls super.takeTurn which determines whether a player is able to make a move or not based on their hand.
    * This method determines how a human user is able to play a card from their hand.
    * */
    @Override
    public boolean takeTurn(Rules r, Deck d, Pile p){
        boolean hasMove;
        Card pileCard = p.topOfPile();
        Card.Suit wildSuit = null;

        hasMove=super.takeTurn(r,d,p);
        sortHand();
        printHand();
        System.out.println("*Top of pile is: "+ p);
    
        while (hasMove){
            System.out.println("Enter a card to play or you may draw once ('dw')");
            Scanner keyboard = new Scanner(System.in);
            String input = keyboard.nextLine();

            if (input.equalsIgnoreCase("dw") && !d.isEmpty()) {
                drawCard(d);
                hasMove=false;
            }
            else if((input.matches("\\d{1,2}[a-zA-z]*")))
            {
                int tempRank= Integer.parseInt(input.replaceAll("[\\D]", ""));
                Card.Suit tempSuit = extractSuit(input.replaceAll("\\d", ""));
                Card tempCard = new Card(tempRank, tempSuit); // create new card based on extracted input

                if(hand.searchCard(tempCard))//check if the card they are requesting is in their hand
                {
                    if(r.isValid(tempCard, pileCard))
                    {
                        for(int i=0; i<hand.getNumCards(); i++)
                        {
                            if(hand.getCard(i).getSuit() == tempCard.getSuit() && hand.getCard(i).getRank() == tempCard.getRank())
                                tempCard=hand.removeCard(hand.getCard(i));
                        }

                        if(tempCard.getRank()==8)
                        {
                            while (wildSuit == null) {
                                System.out.println("Select a suit");
                                keyboard = new Scanner(System.in);
                                input = keyboard.nextLine();

                                wildSuit = extractSuit(input);

                            }//end of while
                        }//end of if

                        System.out.println(getName() +" plays "+ tempCard);

                        if(wildSuit!=null) {
                            System.out.println(getName() +" changed the suit to " +wildSuit);
                            tempCard.setSuit(wildSuit);
                        }

                        addToPile(tempCard, p);
                        hasMove=false;
                    }//end of isvalid if
                    else
                     System.out.println("Invalid move. Please try again. You need to match suit or rank or play an 8");
                }//end of searchcard if
                else
                    System.out.println("Card is not in hand, please try again");
            }//end of else if
            else{
                System.out.println("Incorrect format. Example of card format accepted: 3diamonds or 3d ");
                printHand();
            }
        }//end while loop

        return true;
    }//end Taketurn


    /*Method that takes a string in as a parameter and if that string matches one of the following statements it will return that
    * Card.Suit. If the string does not match any of these statements then an error message is triggered and null is returned.
    * This is used in determining what suit a player is trying to choose after playing an 8
    * */
    private Card.Suit extractSuit(String s)
    {
        if (s.equalsIgnoreCase("S") || s.equalsIgnoreCase("Spades"))
            return Card.Suit.SPADES;
        else if (s.equalsIgnoreCase("H") || s.equalsIgnoreCase("Hearts"))
           return  Card.Suit.HEARTS;
        else if (s.equalsIgnoreCase("C") || s.equalsIgnoreCase("Clubs"))
            return  Card.Suit.CLUBS;
        else if (s.equalsIgnoreCase("D") || s.equalsIgnoreCase("Diamonds"))
            return Card.Suit.DIAMONDS;

        System.out.println("The following inputs for suits are allowed: 'S' or 'Spades', 'H' or 'Hearts', 'C' or 'Clubs', 'D' or 'Diamonds'");
        return null;
    }


}
